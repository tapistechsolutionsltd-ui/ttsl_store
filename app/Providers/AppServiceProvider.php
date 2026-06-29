<?php

namespace App\Providers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\CartItem;
use App\Policies\CartItemPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Cart;
use App\Models\Wishlist;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Gate::policy(CartItem::class, CartItemPolicy::class);

        // Load mail config from DB settings so admin panel overrides .env
        try {
            SettingController::applyMailConfig();
        } catch (\Exception $e) {
            // DB not ready (migrations running, etc.) — fall back to .env silently
        }

        // Share cart count and wishlist count with all views safely
        View::composer('*', function ($view) {
            try {
                $cartCount     = 0;
                $wishlistCount = 0;
                if (auth()->check()) {
                    $cart          = Cart::where('user_id', auth()->id())->first();
                    $cartCount     = $cart ? $cart->item_count : 0;
                    $wishlistCount = Wishlist::where('user_id', auth()->id())->count();
                }
                $view->with('cartCount', $cartCount);
                $view->with('wishlistCount', $wishlistCount);
            } catch (\Exception $e) {
                $view->with('cartCount', 0);
                $view->with('wishlistCount', 0);
            }
        });
    }
}
