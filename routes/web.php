<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CustomerController as AdminCustomerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureController;
use App\Http\Controllers\Admin\HeroSlideController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\Cpp\ClientController as AdminCppClientController;
use App\Http\Controllers\Admin\Cpp\CodeController as AdminCppCodeController;
use App\Http\Controllers\Admin\Cpp\DashboardController as AdminCppDashboardController;
use App\Http\Controllers\Admin\Cpp\PromotionController as AdminCppPromotionController;
use App\Http\Controllers\Admin\Cpp\ReportController as AdminCppReportController;
use App\Http\Controllers\Admin\Cpp\SettingController as AdminCppSettingController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CppPortalController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaveManController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'sendContact'])->name('contact.send');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/services', [HomeController::class, 'services'])->name('services');

// Save Man AI
Route::post('/saveman/chat', [SaveManController::class, 'chat'])
    ->name('saveman.chat')
    ->middleware('throttle:15,1');

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/category/{category:slug}', [ShopController::class, 'category'])->name('shop.category');
Route::get('/shop/product/{product:slug}', [ShopController::class, 'product'])->name('shop.product');

// Client Promotions Portal (public)
Route::prefix('cpp')->name('cpp.')->group(function () {
    Route::get('/', [CppPortalController::class, 'index'])->name('index');
    Route::post('/search', [CppPortalController::class, 'search'])->name('search');
    Route::get('/{promotion:slug}', [CppPortalController::class, 'show'])->name('show');
    Route::get('/{promotion:slug}/statistics', [CppPortalController::class, 'statistics'])->name('statistics');
});

// Cart routes (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/{cartItem}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/{cartItem}/save', [CartController::class, 'saveForLater'])->name('cart.save');
    Route::post('/cart/{cartItem}/move', [CartController::class, 'moveToCart'])->name('cart.move');
    Route::post('/cart/coupon', [CartController::class, 'applyCoupon'])->name('cart.coupon');
    Route::delete('/cart/coupon/remove', [CartController::class, 'removeCoupon'])->name('cart.coupon.remove');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

    // Customer dashboard
    Route::prefix('account')->name('account.')->group(function () {
        Route::get('/', [CustomerController::class, 'dashboard'])->name('dashboard');
        Route::get('/orders', [CustomerController::class, 'orders'])->name('orders');
        Route::get('/orders/{order}', [CustomerController::class, 'orderDetail'])->name('order.detail');
        Route::get('/profile', [CustomerController::class, 'profile'])->name('profile');
        Route::put('/profile', [CustomerController::class, 'updateProfile'])->name('profile.update');
        Route::put('/profile/password', [CustomerController::class, 'updatePassword'])->name('password.update');
        Route::get('/addresses', [CustomerController::class, 'addresses'])->name('addresses');
        Route::post('/addresses', [CustomerController::class, 'storeAddress'])->name('address.store');
        Route::delete('/addresses/{address}', [CustomerController::class, 'deleteAddress'])->name('address.delete');
        Route::get('/wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
        Route::post('/wishlist/toggle', [CustomerController::class, 'toggleWishlist'])->name('wishlist.toggle');
    });
});

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Products
    Route::delete('/products/images/{image}', [ProductController::class, 'deleteImage'])->name('products.image.delete');
    Route::delete('/products/{product}/preview', [ProductController::class, 'deletePreview'])->name('products.preview.delete');
    Route::resource('products', ProductController::class)->except(['show']);

    // Categories
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Brands
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');

    // Features (selectable website add-ons)
    Route::get('/features', [FeatureController::class, 'index'])->name('features.index');
    Route::post('/features', [FeatureController::class, 'store'])->name('features.store');
    Route::put('/features/{feature}', [FeatureController::class, 'update'])->name('features.update');
    Route::delete('/features/{feature}', [FeatureController::class, 'destroy'])->name('features.destroy');

    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::delete('/orders/bulk-delete', [AdminOrderController::class, 'destroyBulk'])->name('orders.bulk-delete');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('/orders/{order}/attachment', [AdminOrderController::class, 'downloadAttachment'])->name('orders.attachment');
    Route::get('/orders/{order}/client-pdf', [AdminOrderController::class, 'clientPdf'])->name('orders.client.pdf');

    // Customers
    Route::get('/customers', [AdminCustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{user}', [AdminCustomerController::class, 'show'])->name('customers.show');
    Route::patch('/customers/{user}/toggle', [AdminCustomerController::class, 'toggleStatus'])->name('customers.toggle');

    // Hero Slides
    Route::resource('hero-slides', HeroSlideController::class);
    Route::patch('/hero-slides/{heroSlide}/toggle', [HeroSlideController::class, 'toggleActive'])->name('hero-slides.toggle');
    Route::post('/hero-slides/reorder', [HeroSlideController::class, 'reorder'])->name('hero-slides.reorder');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings/mail', [SettingController::class, 'updateMail'])->name('settings.mail');
    Route::post('/settings/contact', [SettingController::class, 'updateContact'])->name('settings.contact');
    Route::post('/settings/store', [SettingController::class, 'updateStore'])->name('settings.store');
    Route::post('/settings/test-mail', [SettingController::class, 'testMail'])->name('settings.test-mail');
    Route::post('/settings/social', [SettingController::class, 'updateSocial'])->name('settings.social');
    Route::post('/settings/order-notifications', [SettingController::class, 'updateOrderNotifications'])->name('settings.order-notifications');
    Route::post('/settings/saveman', [SettingController::class, 'updateSaveMan'])->name('settings.saveman');

    // Sidebar badge counts
    Route::get('/badges', [DashboardController::class, 'badges'])->name('badges');

    // Reports
    Route::get('/reports/sales', [ReportController::class, 'sales'])->name('reports.sales');
    Route::get('/reports/sales/download', [ReportController::class, 'salesDownload'])->name('reports.sales.download');
    Route::get('/reports/sales/pdf', [ReportController::class, 'salesPdf'])->name('reports.sales.pdf');
    Route::get('/reports/products', [ReportController::class, 'products'])->name('reports.products');
    Route::get('/reports/inventory', [ReportController::class, 'inventory'])->name('reports.inventory');
    Route::get('/reports/customers', [ReportController::class, 'customers'])->name('reports.customers');
    Route::get('/reports/customers/download', [ReportController::class, 'customersDownload'])->name('reports.customers.download');

    // Client Promotions Portal (CPP)
    Route::prefix('cpp')->name('cpp.')->group(function () {
        Route::get('/', [AdminCppDashboardController::class, 'index'])->name('dashboard');

        Route::resource('promotions', AdminCppPromotionController::class)->except(['show']);

        Route::get('/clients', [AdminCppClientController::class, 'index'])->name('clients.index');
        Route::get('/clients/{client}', [AdminCppClientController::class, 'show'])->name('clients.show');
        Route::put('/clients/{client}', [AdminCppClientController::class, 'update'])->name('clients.update');
        Route::post('/clients/{client}/timeline', [AdminCppClientController::class, 'updateTimeline'])->name('clients.timeline');
        Route::patch('/clients/{client}/deactivate', [AdminCppClientController::class, 'deactivate'])->name('clients.deactivate');
        Route::delete('/clients/{client}', [AdminCppClientController::class, 'destroy'])->name('clients.destroy');

        Route::get('/codes', [AdminCppCodeController::class, 'index'])->name('codes.index');
        Route::post('/codes/{client}/generate', [AdminCppCodeController::class, 'generate'])->name('codes.generate');
        Route::patch('/codes/{code}/expire', [AdminCppCodeController::class, 'expire'])->name('codes.expire');
        Route::patch('/codes/{code}/cancel', [AdminCppCodeController::class, 'cancel'])->name('codes.cancel');
        Route::post('/codes/{code}/reassign', [AdminCppCodeController::class, 'reassign'])->name('codes.reassign');

        Route::get('/reports/registrations', [AdminCppReportController::class, 'registrations'])->name('reports.registrations');
        Route::get('/reports/registrations/download', [AdminCppReportController::class, 'registrationsDownload'])->name('reports.registrations.download');
        Route::get('/reports/registrations/pdf', [AdminCppReportController::class, 'registrationsPdf'])->name('reports.registrations.pdf');

        Route::get('/settings', [AdminCppSettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [AdminCppSettingController::class, 'update'])->name('settings.update');
    });
});

require __DIR__ . '/auth.php';
