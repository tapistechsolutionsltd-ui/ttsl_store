<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function updateMail(Request $request)
    {
        $request->validate([
            'mail_mailer'       => 'required|in:log,smtp,sendmail,gmail',
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|integer|min:1|max:65535',
            'mail_encryption'   => 'nullable|in:,tls,ssl',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_from_address' => 'required|email|max:255',
            'mail_from_name'    => 'required|string|max:255',
        ]);

        // Gmail preset — normalise to smtp with locked-in Gmail server values
        if ($request->input('mail_mailer') === 'gmail') {
            $request->merge([
                'mail_mailer'     => 'smtp',
                'mail_host'       => 'smtp.gmail.com',
                'mail_port'       => 587,
                'mail_encryption' => 'tls',
            ]);
        }

        $fields = ['mail_mailer', 'mail_host', 'mail_port', 'mail_encryption',
                   'mail_username', 'mail_from_address', 'mail_from_name'];

        foreach ($fields as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        // Only overwrite password if a new one was provided
        $newPassword = $request->input('mail_password', '');
        if ($newPassword !== '') {
            Setting::set('mail_password', $newPassword);
        }

        return back()->with('success', 'Mail settings saved successfully.');
    }

    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_recipient_email' => 'required|email|max:255',
            'contact_cc_email'        => 'nullable|email|max:255',
            'contact_subject_prefix'  => 'nullable|string|max:100',
            'contact_auto_reply'      => 'nullable|boolean',
            'contact_auto_reply_msg'  => 'nullable|string|max:2000',
        ]);

        $fields = ['contact_recipient_email', 'contact_cc_email',
                   'contact_subject_prefix', 'contact_auto_reply_msg'];

        foreach ($fields as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        Setting::set('contact_auto_reply', $request->boolean('contact_auto_reply') ? '1' : '0');

        return back()->with('success', 'Contact form settings saved successfully.');
    }

    public function updateSocial(Request $request)
    {
        $request->validate([
            'google_client_id'     => 'nullable|string|max:255',
            'google_client_secret' => 'nullable|string|max:255',
        ]);

        Setting::set('google_login_enabled', $request->boolean('google_login_enabled') ? '1' : '0');
        Setting::set('google_client_id', $request->input('google_client_id', ''));

        $newSecret = $request->input('google_client_secret', '');
        if ($newSecret !== '') {
            Setting::set('google_client_secret', $newSecret);
        }

        return back()->with('success', 'Social login settings saved successfully.');
    }

    public function updateStore(Request $request)
    {
        $request->validate([
            'store_name'    => 'required|string|max:255',
            'store_phone'   => 'nullable|string|max:50',
            'store_email'   => 'nullable|email|max:255',
            'store_address' => 'nullable|string|max:500',
            'store_website' => 'nullable|url|max:255',
        ]);

        foreach (['store_name', 'store_phone', 'store_email', 'store_address', 'store_website'] as $key) {
            Setting::set($key, $request->input($key, ''));
        }

        return back()->with('success', 'Store information saved successfully.');
    }

    public function updateOrderNotifications(Request $request)
    {
        $request->validate([
            'order_confirmation_from_email' => 'required|email|max:255',
            'order_confirmation_from_name'  => 'required|string|max:255',
            'order_alert_email'             => 'nullable|email|max:255',
        ]);

        Setting::set('order_confirmation_enabled', $request->boolean('order_confirmation_enabled') ? '1' : '0');
        Setting::set('order_confirmation_from_email', $request->input('order_confirmation_from_email'));
        Setting::set('order_confirmation_from_name', $request->input('order_confirmation_from_name'));
        Setting::set('order_alert_enabled', $request->boolean('order_alert_enabled') ? '1' : '0');
        Setting::set('order_alert_email', $request->input('order_alert_email', ''));

        return redirect()->route('admin.settings.index')
            ->with('success', 'Order notification settings saved successfully.')
            ->with('active_tab', 'orders');
    }

    public function updateSaveMan(Request $request)
    {
        Setting::set('saveman_enabled', $request->boolean('saveman_enabled') ? '1' : '0');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Save Man AI settings saved.')
            ->with('active_tab', 'saveman');
    }

    public function testMail(Request $request)
    {
        $request->validate(['test_email' => 'required|email']);

        try {
            $this->applyMailConfig();

            $to       = $request->input('test_email');
            $from     = Setting::get('mail_from_address', config('mail.from.address'));
            $fromName = Setting::get('mail_from_name', config('mail.from.name'));

            $storeName  = Setting::get('store_name', config('app.name', 'TTSL Store'));
            $storePhone = Setting::get('store_phone', '');
            $storeEmail = Setting::get('store_email', '');
            $storeWebsite = rtrim(Setting::get('store_website', config('app.url')), '/') ?: config('app.url');
            $appUrl = rtrim(config('app.url'), '/');

            $sharedData = [
                'storeName'    => $storeName,
                'storePhone'   => $storePhone,
                'storeEmail'   => $storeEmail,
                'storeWebsite' => $storeWebsite,
                'logoUrl'      => $appUrl . '/images/Logo.png',
                'logoUrlWhite' => $appUrl . '/images/logo_white.png',
                'senderName'   => 'Admin Test',
                'senderEmail'  => $to,
                'subject'      => 'SMTP Configuration Test',
                'body'         => "This is a test message sent from your NextGen Store admin panel.\n\nIf you can read this, your mail configuration is working correctly.\n\nDriver: " . Setting::get('mail_mailer', 'log') . "\nHost: " . Setting::get('mail_host', 'N/A') . ":" . Setting::get('mail_port', ''),
            ];

            \Illuminate\Support\Facades\Mail::send('emails.contact-admin', $sharedData, function ($message) use ($to, $from, $fromName) {
                $message->to($to)
                        ->subject('Test Email — ' . Setting::get('store_name', 'TTSL Store') . ' SMTP Check')
                        ->from($from, $fromName);
            });

            return back()->with('success', "Test email sent successfully to {$to}. Check your inbox.");
        } catch (\Throwable $e) {
            Log::error('Test mail failed: ' . $e->getMessage());
            return back()->with('mail_error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    public static function applyMailConfig(): void
    {
        $keys = ['mail_mailer', 'mail_host', 'mail_port', 'mail_encryption',
                 'mail_username', 'mail_password', 'mail_from_address', 'mail_from_name'];

        $s = Setting::getMany($keys);

        if (empty($s)) {
            return;
        }

        $password = !empty($s['mail_password']) ? $s['mail_password'] : null;

        config([
            'mail.default'                 => $s['mail_mailer']       ?? config('mail.default'),
            'mail.mailers.smtp.host'       => $s['mail_host']         ?? '',
            'mail.mailers.smtp.port'       => (int)($s['mail_port']   ?? 587),
            'mail.mailers.smtp.encryption' => ($s['mail_encryption'] ?? '') ?: null,
            'mail.mailers.smtp.username'   => $s['mail_username']     ?? null,
            'mail.mailers.smtp.password'   => $password,
            'mail.from.address'            => $s['mail_from_address'] ?? config('mail.from.address'),
            'mail.from.name'               => $s['mail_from_name']    ?? config('mail.from.name'),
        ]);

        // Purge cached mailer so the new config is picked up (may not be bound yet during boot)
        try {
            app('mail.manager')->purge(config('mail.default'));
        } catch (\Throwable $e) {
            // Not yet bound — config() changes above are still in effect
        }
    }
}
