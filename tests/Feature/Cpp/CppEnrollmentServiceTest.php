<?php

namespace Tests\Feature\Cpp;

use App\Models\Category;
use App\Models\CppPromotion;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Cpp\CppEnrollmentService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CppEnrollmentServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_ordering_a_cpp_enabled_product_creates_client_and_code(): void
    {
        Mail::fake();

        $promotion = CppPromotion::create(['title' => 'July Website Promo', 'status' => 'published', 'max_clients' => 5]);
        $product = $this->makeProduct($promotion);
        [$order, $item] = $this->makeOrderWithItem($product);

        $client = app(CppEnrollmentService::class)->enrollFromOrderItem($order, $item);

        $this->assertNotNull($client);
        $this->assertDatabaseHas('cpp_clients', ['order_id' => $order->id, 'product_id' => $product->id]);
        $this->assertDatabaseCount('cpp_codes', 1);
        $this->assertEquals(1, $promotion->registeredCount());
    }

    public function test_promotion_closes_once_max_clients_is_reached_but_checkout_still_succeeds(): void
    {
        Mail::fake();

        $promotion = CppPromotion::create(['title' => 'Limited Promo', 'status' => 'published', 'max_clients' => 1]);
        $product = $this->makeProduct($promotion);

        [$order1, $item1] = $this->makeOrderWithItem($product);
        $client1 = app(CppEnrollmentService::class)->enrollFromOrderItem($order1, $item1);
        $this->assertNotNull($client1);

        $promotion->refresh();
        $this->assertEquals('closed', $promotion->status);

        [$order2, $item2] = $this->makeOrderWithItem($product);
        $client2 = app(CppEnrollmentService::class)->enrollFromOrderItem($order2, $item2);

        $this->assertNull($client2, 'No further enrollment should happen once the promotion is full.');
        $this->assertDatabaseHas('orders', ['id' => $order2->id]);
    }

    private function makeProduct(CppPromotion $promotion): Product
    {
        $category = Category::create(['name' => 'Websites', 'slug' => 'websites-' . uniqid()]);
        return Product::create([
            'category_id' => $category->id, 'name' => 'Business Website', 'price' => 500, 'stock' => 50, 'status' => 'active',
            'cpp_enabled' => true, 'cpp_promotion_id' => $promotion->id,
        ]);
    }

    private function makeOrderWithItem(Product $product): array
    {
        $user = User::create(['name' => 'Test User', 'email' => uniqid() . '@example.com', 'password' => 'secret', 'role' => 'customer']);
        $order = Order::create([
            'user_id' => $user->id, 'order_number' => 'TTSL-' . uniqid(), 'shipping_address' => ['full_name' => 'Test User'],
            'subtotal' => 500, 'total' => 500,
        ]);
        $item = OrderItem::create([
            'order_id' => $order->id, 'product_id' => $product->id, 'product_name' => $product->name,
            'product_sku' => $product->sku, 'quantity' => 1, 'price' => 500, 'total' => 500,
        ]);

        return [$order, $item];
    }
}
