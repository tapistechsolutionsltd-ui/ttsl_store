<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Admin\SettingController;
use App\Models\Category;
use App\Models\HeroSlide;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['images', 'category', 'brand'])
            ->active()->featured()->inStock()->latest()->take(8)->get();

        $newArrivals = Product::with(['images', 'category', 'brand'])
            ->active()->latest()->take(8)->get();

        $categories = Category::where('status', true)
            ->withCount(['activeProducts'])
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::where('status', true)->take(12)->get();
        $heroSlides = HeroSlide::active()->get();

        return view('pages.home', compact('featuredProducts', 'newArrivals', 'categories', 'brands', 'heroSlides'));
    }

    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function faq()
    {
        return view('pages.faq');
    }

    public function terms()
    {
        return view('pages.terms');
    }

    public function privacy()
    {
        return view('pages.privacy');
    }

    public function services()
    {
        return view('pages.services');
    }

    public function sendContact(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        $recipient  = Setting::get('contact_recipient_email', config('mail.from.address'));
        $cc         = Setting::get('contact_cc_email', '');
        $prefix     = Setting::get('contact_subject_prefix', '[TTSL Store]');
        $autoReply  = Setting::get('contact_auto_reply', '0') === '1';
        $autoMsg    = Setting::get('contact_auto_reply_msg', '');
        $storeName  = Setting::get('store_name', 'TTSolutions Limited');
        $storePhone = Setting::get('store_phone', '');
        $storeEmail = Setting::get('store_email', '');
        $storeWebsite = rtrim(Setting::get('store_website', config('app.url')), '/');

        $name    = $request->input('name');
        $email   = $request->input('email');
        $subject = $request->input('subject');
        $body    = $request->input('message');

        $appUrl      = rtrim(config('app.url'), '/');
        $logoUrl      = $appUrl . '/images/Logo.png';
        $logoUrlWhite = $appUrl . '/images/logo_white.png';

        $sharedData = [
            'storeName'    => $storeName,
            'storePhone'   => $storePhone,
            'storeEmail'   => $storeEmail,
            'storeWebsite' => $storeWebsite ?: $appUrl,
            'logoUrl'      => $logoUrl,
            'logoUrlWhite' => $logoUrlWhite,
            'senderName'   => $name,
            'senderEmail'  => $email,
            'subject'      => $subject,
            'body'         => $body,
        ];

        try {
            SettingController::applyMailConfig();

            $fullSubject = trim($prefix . ' ' . $subject);

            Mail::send('emails.contact-admin', $sharedData, function ($message) use ($recipient, $cc, $fullSubject, $email, $name) {
                $message->to($recipient)->subject($fullSubject)->replyTo($email, $name);
                if ($cc) {
                    $message->cc($cc);
                }
            });

            if ($autoReply && $autoMsg) {
                $replyData = array_merge($sharedData, ['autoReplyMessage' => $autoMsg]);
                Mail::send('emails.contact-autoreply', $replyData, function ($message) use ($email, $name, $subject) {
                    $message->to($email, $name)->subject('Re: ' . $subject);
                });
            }
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}
