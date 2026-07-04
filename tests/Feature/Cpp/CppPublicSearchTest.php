<?php

namespace Tests\Feature\Cpp;

use App\Models\Category;
use App\Models\CppClient;
use App\Models\CppPromotion;
use App\Models\Order;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use App\Services\Cpp\CppCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CppPublicSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_code_returns_only_public_fields(): void
    {
        $client = $this->makeRegisteredClient();
        $code = app(CppCodeService::class)->generate($client);

        $response = $this->postJson(route('cpp.search'), ['code' => $code->code]);

        $response->assertOk()
            ->assertJson(['found' => true, 'code' => $code->code])
            ->assertJsonStructure(['company_name', 'code', 'promotion_title', 'product_name', 'current_status', 'timeline']);

        $response->assertJsonMissingPath('email');
        $response->assertJsonMissingPath('phone');
        $this->assertStringNotContainsString($client->user->email, $response->getContent());
    }

    public function test_invalid_code_returns_not_found(): void
    {
        $response = $this->postJson(route('cpp.search'), ['code' => 'CPP-NOTREAL-0000']);

        $response->assertOk()->assertJson(['found' => false]);
    }

    public function test_search_disabled_setting_blocks_search(): void
    {
        Setting::set('cpp_search_enabled', '0');

        $response = $this->postJson(route('cpp.search'), ['code' => 'ANYTHING']);

        $response->assertStatus(403)->assertJson(['found' => false]);
    }

    private function makeRegisteredClient(): CppClient
    {
        $promotion = CppPromotion::create(['title' => 'Test Promo', 'status' => 'published']);
        $category = Category::create(['name' => 'Websites', 'slug' => 'websites-' . uniqid()]);
        $product = Product::create(['category_id' => $category->id, 'name' => 'Business Website', 'price' => 500, 'stock' => 10, 'status' => 'active']);
        $user = User::create(['name' => 'Test User', 'email' => 'secret-' . uniqid() . '@example.com', 'password' => 'secret', 'role' => 'customer']);
        $order = Order::create([
            'user_id' => $user->id, 'order_number' => 'TTSL-' . uniqid(), 'shipping_address' => ['full_name' => 'Test User'],
            'subtotal' => 500, 'total' => 500,
        ]);

        return CppClient::create([
            'cpp_promotion_id' => $promotion->id,
            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
            'company_name' => 'ABC Ltd',
        ]);
    }
}
