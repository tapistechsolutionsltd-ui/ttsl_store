<?php

namespace Tests\Feature\Cpp;

use App\Models\CppClient;
use App\Models\CppPromotion;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Services\Cpp\CppCodeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CppCodeGenerationTest extends TestCase
{
    use RefreshDatabase;

    public function test_generated_codes_are_unique_and_correctly_formatted(): void
    {
        $client1 = $this->makeClient();
        $client2 = $this->makeClient();

        $service = app(CppCodeService::class);
        $code1 = $service->generate($client1);
        $code2 = $service->generate($client2);

        $this->assertNotEquals($code1->code, $code2->code);

        $monthKey = strtoupper(now()->format('My'));
        $this->assertMatchesRegularExpression("/^CPP-{$monthKey}-\\d{4}$/", $code1->code);
        $this->assertMatchesRegularExpression("/^CPP-{$monthKey}-\\d{4}$/", $code2->code);
    }

    private function makeClient(): CppClient
    {
        $promotion = CppPromotion::create(['title' => 'Test Promo', 'status' => 'published']);
        $user = User::create(['name' => 'Test User', 'email' => uniqid() . '@example.com', 'password' => 'secret', 'role' => 'customer']);
        $category = \App\Models\Category::create(['name' => 'Websites', 'slug' => 'websites-' . uniqid()]);
        $product = Product::create(['category_id' => $category->id, 'name' => 'Business Website ' . uniqid(), 'price' => 500, 'stock' => 10, 'status' => 'active']);
        $order = Order::create([
            'user_id' => $user->id, 'order_number' => 'TTSL-' . uniqid(), 'shipping_address' => ['full_name' => 'Test User'],
            'subtotal' => 500, 'total' => 500,
        ]);

        return CppClient::create([
            'cpp_promotion_id' => $promotion->id,
            'user_id' => $user->id,
            'order_id' => $order->id,
            'product_id' => $product->id,
        ]);
    }
}
