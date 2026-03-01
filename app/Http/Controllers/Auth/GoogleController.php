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

        // Check if a user with this google_id already exists
        $user = User::where('google_id', $googleUser->getId())->first();

        if ($user) {
            // Existing Google user — already registered
            Auth::login($user, true);

            $redirect = $user->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
            return $redirect->with('google_alert', [
                'type' => 'warning',
                'message' => 'Akun Google ini sudah terdaftar sebelumnya. Anda berhasil masuk ke akun yang sudah ada.',
            ]);
        } else {
            // Check if a user with the same email already exists (registered manually)
            $existingUser = User::where('email', $googleUser->getEmail())->first();

            if ($existingUser) {
                // Link Google to existing account
                $existingUser->update(['google_id' => $googleUser->getId()]);
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
                    'email' => $googleUser->getEmail(),
                    'google_id' => $googleUser->getId(),
                    'password' => Hash::make(Str::random(24)),
                    'role' => 'customer',
                ]);
                Auth::login($user, true);

                return redirect()->route('home')->with('google_alert', [
                    'type' => 'success',
                    'message' => 'Selamat! Akun Anda berhasil dibuat dengan Google. Selamat datang di Light Star!',
                ]);
            }
        }
    }
}
