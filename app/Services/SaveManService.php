<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Support\Collection;

class SaveManService
{
    private Collection $products;
    private Collection $categories;
    private array      $store;

    public function __construct()
    {
        try {
            $this->products   = Product::where('status', 'active')->with('category')->orderBy('name')->get();
            $this->categories = Category::where('status', true)->get();
        } catch (\Exception $e) {
            $this->products   = collect();
            $this->categories = collect();
        }

        $this->store = [
            'name'    => Setting::get('store_name',    'TTSolutions Limited') ?? 'TTSolutions Limited',
            'email'   => Setting::get('store_email',   'ttsl.support@gmail.com') ?? 'ttsl.support@gmail.com',
            'phone'   => Setting::get('store_phone',   '+675 7224 3900') ?? '+675 7224 3900',
            'website' => Setting::get('store_website', 'https://www.ttsolutionspng.com') ?? 'https://www.ttsolutionspng.com',
        ];
    }

    public function chat(string $userMessage, array $history = []): string
    {
        if ((Setting::get('saveman_enabled', '1') ?? '1') !== '1') {
            return "Save Man is currently offline.\n\nFor help: {$this->store['email']} | {$this->store['phone']}";
        }

        return $this->respond(trim($userMessage));
    }

    // ── Core engine ───────────────────────────────────────────────────

    private function respond(string $raw): string
    {
        $text = strtolower($raw);
        $text = preg_replace('/[^\w\s]/', ' ', $text);
        $text = preg_replace('/\s+/', ' ', trim($text));

        $productMatch  = $this->matchProduct($text);
        $categoryMatch = $productMatch ? null : $this->matchCategory($text);

        $intent = $this->detectIntent($text, $productMatch, $categoryMatch);

        return $this->buildResponse($intent, $text, $productMatch, $categoryMatch);
    }

    private function detectIntent(string $text, ?Product $product, ?Category $category): string
    {
        if ($product)  return 'specific_product';
        if ($category) return 'category_products';

        $map = [
            'greeting'     => ['hi ', 'hello', 'hey ', 'howdy', 'good morning', 'good afternoon', 'good evening', 'good day', 'greetings'],
            'farewell'     => ['bye', 'goodbye', 'see you', 'see ya', 'later', 'take care', 'farewell', 'good night', 'ciao'],
            'thanks'       => ['thank you', 'thanks', 'appreciate', 'cheers', 'great help', 'very helpful'],
            'order'        => ['how to order', 'how do i order', 'how to buy', 'how do i buy', 'how to purchase', 'how do i purchase', 'place an order', 'steps to order', 'ordering process', 'how to start', 'how do i get'],
            'payment'      => ['how to pay', 'payment method', 'payment option', 'bank account', 'account number', 'bank transfer', 'bsp', 'kina bank', 'receipt', 'how do i pay', 'where do i pay', 'bank detail', 'deposit amount', 'how much deposit'],
            'pricing'      => ['how much', 'price list', 'pricing', 'rates', 'cost of', 'all prices', 'price range', 'cheapest', 'most expensive', 'how much does'],
            'products'     => ['what services', 'what do you offer', 'what products', 'your products', 'your services', 'list of services', 'services you offer', 'show me', 'what can i buy', 'what can you do', 'catalog', 'available service', 'offerings'],
            'categories'   => ['categories', 'category', 'types of service', 'kinds of service'],
            'timeline'     => ['how long', 'when will', 'timeline', 'duration', 'completion time', 'how many days', 'turnaround', 'delivery time', 'when can i get', 'how soon', 'how fast'],
            'contact'      => ['contact', 'email address', 'phone number', 'call you', 'reach you', 'get in touch', 'whatsapp', 'speak to someone', 'talk to human', 'support team'],
            'about'        => ['about ttsl', 'about ttsolutions', 'who are you', 'what is ttsl', 'tell me about', 'who is ttsl', 'company info', 'your company', 'where are you located', 'png company', 'about save man'],
            'account'      => ['login', 'log in', 'sign up', 'register', 'create account', 'my account', 'forgot password', 'reset password', 'create a account'],
            'cart'         => ['shopping cart', 'my cart', 'view cart', 'add to cart', 'remove from cart'],
            'order_status' => ['my order', 'order status', 'track my order', 'where is my order', 'check order', 'order progress'],
        ];

        foreach ($map as $intent => $phrases) {
            foreach ($phrases as $phrase) {
                if (str_contains($text, $phrase)) {
                    return $intent;
                }
            }
        }

        // Keyword search across product names + descriptions
        $words = array_filter(explode(' ', $text), fn($w) => strlen($w) > 3);
        foreach ($words as $word) {
            $hits = $this->products->filter(fn($p) =>
                str_contains(strtolower($p->name), $word) ||
                str_contains(strtolower(strip_tags($p->description ?? '')), $word)
            );
            if ($hits->isNotEmpty()) {
                return 'keyword_search:' . $word;
            }
        }

        return 'unknown';
    }

    private function matchProduct(string $text): ?Product
    {
        return $this->products->first(fn($p) => str_contains($text, strtolower($p->name)));
    }

    private function matchCategory(string $text): ?Category
    {
        return $this->categories->first(fn($c) => str_contains($text, strtolower($c->name)));
    }

    private function buildResponse(string $intent, string $text, ?Product $product, ?Category $category): string
    {
        if (str_starts_with($intent, 'keyword_search:')) {
            return $this->responseKeywordSearch(str_replace('keyword_search:', '', $intent));
        }

        return match ($intent) {
            'greeting'        => $this->responseGreeting(),
            'farewell'        => $this->responseFarewell(),
            'thanks'          => $this->responseThanks(),
            'products'        => $this->responseProducts(),
            'pricing'         => $this->responsePricing(),
            'specific_product'=> $this->responseProduct($product),
            'category_products'=> $this->responseCategoryProducts($category),
            'categories'      => $this->responseCategories(),
            'order'           => $this->responseOrder(),
            'payment'         => $this->responsePayment(),
            'timeline'        => $this->responseTimeline(),
            'contact'         => $this->responseContact(),
            'about'           => $this->responseAbout(),
            'account'         => $this->responseAccount(),
            'cart'            => $this->responseCart(),
            'order_status'    => $this->responseOrderStatus(),
            default           => $this->responseFallback(),
        };
    }

    // ── Response builders ─────────────────────────────────────────────

    private function responseGreeting(): string
    {
        $h = (int) now()->format('H');
        $g = $h < 12 ? 'Good morning' : ($h < 17 ? 'Good afternoon' : 'Good evening');
        return "{$g}! 👋 Welcome to {$this->store['name']}.\n\nI'm Save Man — your built-in AI assistant. I can help you with:\n\n• Our products & services\n• Pricing information\n• How to place an order\n• Payment methods\n• Project timelines\n• Contact & support\n\nWhat can I help you with today?";
    }

    private function responseFarewell(): string
    {
        return "Thanks for visiting {$this->store['name']}! 😊\n\nFeel free to chat anytime — I'm always here. Have a great day! 👋";
    }

    private function responseThanks(): string
    {
        return "You're very welcome! 😊 Happy to help.\n\nIs there anything else you'd like to know?";
    }

    private function responseProducts(): string
    {
        if ($this->products->isEmpty()) {
            return "Our product catalog is currently being updated.\n\nPlease contact us at {$this->store['email']} for the latest services.";
        }

        $lines = $this->products->map(fn($p) =>
            ($p->stock > 0 ? '✓' : '✗') . ' ' . $p->name . ' — ' . $this->price($p)
        )->join("\n");

        return "Here are our " . $this->products->count() . " available services:\n\n{$lines}\n\nAsk me about any service by name for full details, or ask \"how to order\" to get started! 🛒";
    }

    private function responsePricing(): string
    {
        if ($this->products->isEmpty()) {
            return "Please contact us for pricing:\n📧 {$this->store['email']}\n📞 {$this->store['phone']}";
        }

        $lines = $this->products->map(function ($p) {
            $cat = $p->category->name ?? 'General';
            return "  • {$p->name} ({$cat}) — " . $this->price($p);
        })->join("\n");

        return "Our full pricing list:\n\n{$lines}\n\n💡 A 50% deposit is required to start any project. The balance is due on completion.\n\nInterested in a specific service? Ask me for details!";
    }

    private function responseProduct(?Product $p): string
    {
        if (!$p) return $this->responseFallback();

        $cat      = $p->category->name ?? 'General';
        $price    = $this->price($p);
        $stock    = $p->stock > 0 ? "✅ Available ({$p->stock} slot" . ($p->stock !== 1 ? 's' : '') . " remaining)" : "❌ Currently unavailable";
        $desc     = $p->description ? "\n\n" . substr(strip_tags($p->description), 0, 300) : '';
        $duration = $p->development_duration ? "\n⏱ Estimated time: {$p->development_duration}" : '';

        return "📦 {$p->name}\n\nCategory:  {$cat}\nPrice:     {$price}{$duration}\nStatus:    {$stock}{$desc}\n\nTo order this service:\n1. Add it to your cart\n2. Proceed to checkout\n3. Fill in your project details\n\nWould you like to know how to place an order? Just ask!";
    }

    private function responseCategories(): string
    {
        if ($this->categories->isEmpty()) {
            return "Please browse our shop for all available categories, or contact us at {$this->store['email']}.";
        }

        $lines = $this->categories->map(function ($c) {
            $count = $this->products->where('category_id', $c->id)->count();
            return "  • {$c->name} ({$count} service" . ($count !== 1 ? 's' : '') . ")";
        })->join("\n");

        return "We offer services across these categories:\n\n{$lines}\n\nAsk me about any category to see what's available and the pricing!";
    }

    private function responseCategoryProducts(?Category $cat): string
    {
        if (!$cat) return $this->responseProducts();

        $products = $this->products->where('category_id', $cat->id);
        if ($products->isEmpty()) return $this->responseProducts();

        $lines = $products->map(fn($p) =>
            "  • {$p->name} — " . $this->price($p) . ($p->stock < 1 ? ' (unavailable)' : '')
        )->join("\n");

        return "Here are our {$cat->name} services:\n\n{$lines}\n\nAsk me about any of these services by name for full details!";
    }

    private function responseKeywordSearch(string $term): string
    {
        $found = $this->products->filter(fn($p) =>
            str_contains(strtolower($p->name), $term) ||
            str_contains(strtolower(strip_tags($p->description ?? '')), $term)
        );

        if ($found->isEmpty()) return $this->responseFallback();

        $lines = $found->map(fn($p) => "  • {$p->name} — " . $this->price($p))->join("\n");

        return "Here's what I found matching \"{$term}\":\n\n{$lines}\n\nWould you like more details on any of these?";
    }

    private function responseOrder(): string
    {
        return "Here's how to place an order:\n\n1️⃣  Browse the Shop and find a service\n2️⃣  Click it → Add to Cart\n3️⃣  Go to Cart → Proceed to Checkout\n4️⃣  Fill in your details:\n     • Full name, email & phone\n     • Project brief / requirements\n     • Upload any reference files\n5️⃣  Choose your payment method\n6️⃣  Click Confirm & Place Order\n7️⃣  You'll receive an email confirmation\n8️⃣  Make your 50% deposit bank transfer\n9️⃣  Our team starts work on your project!\n\n💡 You need to be logged in to checkout.\n\nNeed help finding the right service? Just ask!";
    }

    private function responsePayment(): string
    {
        return "We accept the following payments:\n\n🏦 Bank Transfer (Preferred)\n\n   BSP Waigani Branch:\n   Account Name: Jimmy Tapis\n   Account No:   7025374278\n\n   Kina Vision City:\n   Account Name: Jimmy Tapis\n   Account No:   32604018\n\n   Use your ORDER NUMBER as the reference.\n   Email receipt to: {$this->store['email']}\n\n💵 Cash on Completion\n   Available for select projects.\n\n💡 50% deposit required before work begins.\n   Remaining 50% due on project completion.";
    }

    private function responseTimeline(): string
    {
        $timed = $this->products->filter(fn($p) => !empty($p->development_duration));

        if ($timed->isNotEmpty()) {
            $lines = $timed->map(fn($p) => "  • {$p->name}: {$p->development_duration}")->join("\n");
            return "Estimated timelines for our services:\n\n{$lines}\n\n⚠️ Timelines start after your 50% deposit is received and the project brief is confirmed.\n\nContact us for custom timelines: {$this->store['email']}";
        }

        return "Project timelines depend on scope and complexity:\n\n  • Simple projects:   3–7 business days\n  • Standard projects: 1–3 weeks\n  • Complex projects:  3–6 weeks\n\nTimelines start after deposit is received.\n\nFor a specific quote: {$this->store['email']}";
    }

    private function responseContact(): string
    {
        return "Here's how to reach us:\n\n📧 Email:   {$this->store['email']}\n📞 Phone:   {$this->store['phone']}\n🌐 Website: {$this->store['website']}\n📍 Country: Papua New Guinea\n\nBusiness hours: Mon–Fri, 8am–5pm PNG time.\n\nFor project enquiries, email is best — include your requirements for a faster response. 😊";
    }

    private function responseAbout(): string
    {
        $pc = $this->products->count();
        $cc = $this->categories->count();
        return "{$this->store['name']} (TTSL) is a digital services company based in Papua New Guinea. 🇵🇬\n\nTagline: Keeping You Connected\n\nWe provide digital solutions including website development, graphic design, software, branding, and more — helping businesses and individuals across PNG go digital.\n\nCurrently offering {$pc} services across {$cc} categories.\n\n📧 {$this->store['email']}\n📞 {$this->store['phone']}\n🌐 {$this->store['website']}";
    }

    private function responseAccount(): string
    {
        return "Everything about accounts on our store:\n\n👤 Create an Account:\n   • Click Register in the top navigation\n   • Enter your name, email & password\n   • Or sign in with Google\n\n🔑 Log In:\n   • Click Account & Lists → Sign In\n   • Use your email & password\n\n📋 Your account lets you:\n   • View order history\n   • Track project progress\n   • Manage your wishlist\n   • Update your profile\n\nNeed help? {$this->store['email']}";
    }

    private function responseCart(): string
    {
        return "How the shopping cart works:\n\n🛒 Adding items:\n   • Browse shop → click a service\n   • Click Add to Cart\n   • The cart icon (top right) will update\n\n📋 Viewing your cart:\n   • Click the cart icon in the navigation\n   • Review items and quantities\n   • Apply a coupon code if you have one\n\n✅ Checking out:\n   • Click Proceed to Checkout\n   • Fill in your project details\n   • Click Confirm & Place Order\n\n💡 You need to be logged in to use the cart.";
    }

    private function responseOrderStatus(): string
    {
        return "To check your order status:\n\n📋 If logged in:\n   • Click your name (top right)\n   • Go to My Orders\n   • Click any order for full details\n\n📧 Via email:\n   • Check your confirmation email\n   • It has your order number and status\n\n📞 Contact us directly:\n   • Email: {$this->store['email']}\n   • Phone: {$this->store['phone']}\n   • Include your order number\n\nOrder flow: Pending → Processing → In Progress → Completed ✅";
    }

    private function responseFallback(): string
    {
        return "I'm not quite sure about that — could you rephrase? 😊\n\nHere are some things I can help with:\n\n  • \"What services do you offer?\"\n  • \"How do I place an order?\"\n  • \"What are your payment methods?\"\n  • \"How long does a project take?\"\n  • \"How do I contact you?\"\n\nOr reach our team directly:\n📧 {$this->store['email']}\n📞 {$this->store['phone']}";
    }

    // ── Helper ────────────────────────────────────────────────────────

    private function price(Product $p): string
    {
        if ($p->sale_price && $p->sale_price < $p->price) {
            return 'K ' . number_format((float) $p->sale_price, 2) . ' (was K ' . number_format((float) $p->price, 2) . ')';
        }
        return 'K ' . number_format((float) $p->price, 2);
    }
}
