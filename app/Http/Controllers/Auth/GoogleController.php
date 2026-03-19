<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    private function adminEmail(): string
    {
        return (string) config('auth.admin_email');
    }

    private function resolveRoleFromEmail(?string $email): string
    {
        $adminEmail = $this->adminEmail();

        if ($adminEmail === '' || $email === null) {
            return 'customer';
        }

        return strcasecmp($email, $adminEmail) === 0 ? 'admin' : 'customer';
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
        } catch (\Exception $e) {
            return redirect()->route('login')->with('status', 'Gagal terhubung dengan Google. Silakan coba lagi.');
        }

        $googleEmail = $googleUser->getEmail();

        if (!$googleEmail) {
            return redirect()->route('login')->with('status', 'Akun Google tidak memiliki email yang valid.');
        }

        $resolvedRole = $this->resolveRoleFromEmail($googleEmail);

        // Check if a user with this google_id already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            $updates = [];

            if ($googleEmail && strcasecmp($user->email, $googleEmail) !== 0) {
                $updates['email'] = $googleEmail;
            }

            if ($user->role !== $resolvedRole) {
                $updates['role'] = $resolvedRole;
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

            $redirect = $user->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
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
                    'role' => $resolvedRole,
                ];

                $existingUser->update($updates);

                if (is_null($existingUser->email_verified_at)) {
                    $existingUser->forceFill(['email_verified_at' => now()])->save();
                }

                $existingUser->refresh();
                Auth::login($existingUser, true);
                $user = $existingUser;

                $redirect = $user->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
                return $redirect->with('google_alert', [
                    'type' => 'info',
                    'message' => 'Email ini sudah terdaftar. Akun Google Anda berhasil dihubungkan dengan akun yang ada.',
                ]);
            } else {
                // Create a brand new user via Google
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleEmail,
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => $resolvedRole,
                ]);
                $user->forceFill(['email_verified_at' => now()])->save();
                $user->refresh();
                Auth::login($user, true);

                $redirect = $user->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
                return $redirect->with('google_alert', [
                    'type' => 'success',
                    'message' => 'Selamat! Akun Anda berhasil dibuat dengan Google. Selamat datang di Light Star!',
                ]);
            }
        }
    }
}
