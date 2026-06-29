<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
{
    public function redirectToGoogle()
    {
        if (!$this->googleEnabled()) {
            return redirect()->route('login')->withErrors(['email' => 'Google login is not enabled.']);
        }

        $this->applyGoogleConfig();

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleGoogleCallback()
    {
        if (!$this->googleEnabled()) {
            return redirect()->route('login')->withErrors(['email' => 'Google login is not enabled.']);
        }

        $this->applyGoogleConfig();

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            return redirect()->route('login')->withErrors(['email' => 'Google authentication failed. Please try again.']);
        }

        // Find existing user by google_id or email
        $user = User::where('google_id', $googleUser->id)->first()
            ?? User::where('email', $googleUser->email)->first();

        if ($user) {
            // Attach google_id to existing account if not already linked
            $user->fill([
                'google_id' => $googleUser->id,
                'avatar'    => $googleUser->avatar,
            ])->save();
        } else {
            // Register a new user via Google
            $user = User::create([
                'name'              => $googleUser->name,
                'email'             => $googleUser->email,
                'google_id'         => $googleUser->id,
                'avatar'            => $googleUser->avatar,
                'email_verified_at' => now(),
                'password'          => Str::random(32),
                'role'              => 'customer',
                'status'            => 'active',
            ]);
        }

        if ($user->status !== 'active') {
            return redirect()->route('login')->withErrors(['email' => 'Your account has been suspended.']);
        }

        Auth::login($user, true);

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $intended = session()->pull('url.intended', route('account.dashboard'));

        // Ignore AJAX/JSON endpoints stored as intended URL (e.g. /cart/count)
        $isJsonEndpoint = str_contains($intended, '/cart/count')
            || str_contains($intended, '/api/')
            || str_contains($intended, '.json');

        return redirect($isJsonEndpoint ? route('account.dashboard') : $intended);
    }

    private function googleEnabled(): bool
    {
        return Setting::get('google_login_enabled', '0') === '1';
    }

    private function applyGoogleConfig(): void
    {
        $clientId     = Setting::get('google_client_id', config('services.google.client_id'));
        $clientSecret = Setting::get('google_client_secret', config('services.google.client_secret'));

        // Use the explicit GOOGLE_REDIRECT_URI env var so the URI sent to Google
        // exactly matches what is registered in Google Cloud Console.
        // Local: http://localhost/auth/google/callback
        // Production: https://store.nextgenpng.net/auth/google/callback
        $redirect = config('services.google.redirect');
        if (!$redirect || str_starts_with($redirect, '/')) {
            $redirect = url('/auth/google/callback');
        }

        config([
            'services.google.client_id'     => $clientId,
            'services.google.client_secret' => $clientSecret,
            'services.google.redirect'      => $redirect,
        ]);
    }
}
