<x-guest-layout>
    <h2 class="text-2xl font-bold text-white text-center mb-2">Selamat Datang</h2>
    <p class="text-slate-text text-sm text-center mb-6">Masuk ke akun Light Star Anda</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded bg-navy-card border-navy-border text-cyan focus:ring-cyan/30" name="remember">
                <span class="ms-2 text-sm text-slate-text">Ingat saya</span>
            </label>
        </div>

        <div class="mt-6">
            <x-primary-button>
                Sign In
            </x-primary-button>
        </div>

        <div class="mt-4 text-center">
            <span class="text-sm text-slate-text">Belum punya akun?</span>
            <a href="{{ route('register') }}"
                class="text-sm text-cyan hover:text-cyan-light transition-colors ml-1">Daftar sekarang</a>
        </div>
    </form>
</x-guest-layout>