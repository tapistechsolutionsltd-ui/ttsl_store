<?php

namespace Tests\Feature\Cpp;

use App\Models\CppPromotion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CppAdminPromotionCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_a_promotion(): void
    {
        $admin = $this->makeAdmin();

        $response = $this->actingAs($admin)->post(route('admin.cpp.promotions.store'), [
            'title' => 'August Promo',
            'status' => 'draft',
        ]);

        $response->assertRedirect(route('admin.cpp.promotions.index'));
        $this->assertDatabaseHas('cpp_promotions', ['title' => 'August Promo']);
    }

    public function test_admin_can_update_and_delete_a_promotion(): void
    {
        $admin = $this->makeAdmin();
        $promotion = CppPromotion::create(['title' => 'Old Title', 'status' => 'draft']);

        $this->actingAs($admin)->put(route('admin.cpp.promotions.update', $promotion), [
            'title' => 'New Title',
            'status' => 'published',
        ])->assertRedirect(route('admin.cpp.promotions.index'));

        $this->assertDatabaseHas('cpp_promotions', ['id' => $promotion->id, 'title' => 'New Title']);

        $this->actingAs($admin)->delete(route('admin.cpp.promotions.destroy', $promotion))
            ->assertRedirect();

        $this->assertDatabaseMissing('cpp_promotions', ['id' => $promotion->id]);
    }

    public function test_guest_is_blocked_from_admin_promotions(): void
    {
        $this->get(route('admin.cpp.promotions.index'))->assertRedirect(route('login'));
    }

    public function test_non_admin_customer_is_blocked_from_admin_promotions(): void
    {
        $customer = User::create(['name' => 'Cust', 'email' => 'cust@example.com', 'password' => 'secret', 'role' => 'customer', 'status' => 'active']);

        $this->actingAs($customer)->get(route('admin.cpp.promotions.index'))->assertForbidden();
    }

    private function makeAdmin(): User
    {
        return User::create([
            'name' => 'Admin', 'email' => 'admin-' . uniqid() . '@example.com',
            'password' => 'secret', 'role' => 'admin', 'status' => 'active',
        ]);
    }
}
