<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleController extends Controller
{
    private function adminEmail(): string
    {
        return (string) config('auth.admin_email');
    }

    private function shouldForceAdminRole(?string $email): bool
    {
        $adminEmail = $this->adminEmail();

        if ($adminEmail === '' || $email === null) {
            return false;
        }

        return strcasecmp($email, $adminEmail) === 0;
    }

    private function resolveGoogleDisplayName($googleUser, string $googleEmail): string
    {
        $name = trim((string) ($googleUser->getName() ?? ''));

        if ($name !== '') {
            return $name;
        }

        $nickname = trim((string) ($googleUser->getNickname() ?? ''));

        if ($nickname !== '') {
            return $nickname;
        }

        return trim((string) strstr($googleEmail, '@', true));
    }

    /**
     * Redirect the user to Google's OAuth page.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Handle the callback from Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException $e) {
            // Fallback for local/dev environments where session state can be lost.
            try {
                $provider = Socialite::driver('google');

                if (method_exists($provider, 'stateless')) {
                    $provider = call_user_func([$provider, 'stateless']);
                }

                $googleUser = $provider->user();
            } catch (\Exception $inner) {
                Log::warning('Google OAuth callback failed after stateless fallback.', [
                    'error' => $inner->getMessage(),
                ]);

                return redirect()->route('login')->with('status', 'Gagal terhubung dengan Google. Silakan coba lagi.');
            }
        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            Log::warning('Google OAuth callback failed.', [
                'error' => $errorMessage,
            ]);

            if (str_contains(strtolower($errorMessage), 'invalid_client')) {
                return redirect()->route('login')->with('status', 'Konfigurasi Google OAuth belum valid (invalid_client). Silakan perbarui Client ID/Client Secret di .env.');
            }

            return redirect()->route('login')->with('status', 'Gagal terhubung dengan Google. Silakan coba lagi.');
        }

        $googleEmail = $googleUser->getEmail();
        $googleAvatar = $googleUser->getAvatar();

        if (!$googleEmail) {
            return redirect()->route('login')->with('status', 'Akun Google tidak memiliki email yang valid.');
        }

        $googleName = $this->resolveGoogleDisplayName($googleUser, $googleEmail);

        $shouldForceAdmin = $this->shouldForceAdminRole($googleEmail);

        // Check if a user with this google_id already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            $updates = [];

            if ($googleEmail && strcasecmp($user->email, $googleEmail) !== 0) {
                $updates['email'] = $googleEmail;
            }

            if ($googleName !== '' && $user->name !== $googleName) {
                $updates['name'] = $googleName;
            }

            if ($shouldForceAdmin && $user->role !== 'admin') {
                $updates['role'] = 'admin';
            }

            if ($googleAvatar && $user->avatar_url !== $googleAvatar) {
                $updates['avatar_url'] = $googleAvatar;
            }

            $shouldRefresh = false;

            if (!empty($updates)) {
                $user->update($updates);
                $shouldRefresh = true;
            }

            if (is_null($user->email_verified_at)) {
                $user->forceFill(['email_verified_at' => now()])->save();
                $shouldRefresh = true;
            }

            if ($shouldRefresh) {
                $user->refresh();
            }

            // Existing Google user — already registered
            Auth::login($user, true);

            $redirect = $user->isAdmin()
                ? redirect()->intended(route('admin.dashboard'))
                : redirect()->intended(route('home'));
            return $redirect->with('google_alert', [
                'type' => 'warning',
                'message' => 'Akun Google ini sudah terdaftar sebelumnya. Anda berhasil masuk ke akun yang sudah ada.',
            ]);
        } else {
            // Check if a user with the same email already exists (registered manually)
            $existingUser = User::where('email', $googleEmail)->first();

            if ($existingUser) {
                // Link Google to existing account
                $updates = [
                    'google_id' => $googleUser->getId(),
                    'avatar_url' => $googleAvatar,
                ];

                if ($googleName !== '' && $existingUser->name !== $googleName) {
                    $updates['name'] = $googleName;
                }

                if ($shouldForceAdmin && $existingUser->role !== 'admin') {
                    $updates['role'] = 'admin';
                }

                $existingUser->update($updates);

                if (is_null($existingUser->email_verified_at)) {
                    $existingUser->forceFill(['email_verified_at' => now()])->save();
                }

                $existingUser->refresh();
                Auth::login($existingUser, true);
                $user = $existingUser;

                $redirect = $user->isAdmin()
                    ? redirect()->intended(route('admin.dashboard'))
                    : redirect()->intended(route('home'));
                return $redirect->with('google_alert', [
                    'type' => 'info',
                    'message' => 'Email ini sudah terdaftar. Akun Google Anda berhasil dihubungkan dengan akun yang ada.',
                ]);
            } else {
                // Create a brand new user via Google
                $user = User::create([
                    'name' => $googleName,
                    'email' => $googleEmail,
                    'google_id' => $googleUser->getId(),
                    'avatar_url' => $googleAvatar,
                    'password' => Hash::make(Str::random(24)),
                    'role' => $shouldForceAdmin ? 'admin' : 'customer',
                ]);
                $user->forceFill(['email_verified_at' => now()])->save();
                $user->refresh();
                Auth::login($user, true);

                $redirect = $user->isAdmin()
                    ? redirect()->intended(route('admin.dashboard'))
                    : redirect()->intended(route('home'));
                return $redirect->with('google_alert', [
                    'type' => 'success',
                    'message' => 'Selamat! Akun Anda berhasil dibuat dengan Google. Selamat datang di Light Star!',
                ]);
            }
        }
    }
}
