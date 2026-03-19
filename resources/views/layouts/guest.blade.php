<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Light Star') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-navy">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
        {{-- Decorative background elements --}}
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-cyan/5 rounded-full blur-3xl"></div>

        <div class="relative z-10">
            <a href="/" class="flex items-center gap-3 mb-8 justify-center">
                <img src="{{ asset('assets/images/light-star-media-logo.png') }}" alt="Light Star Media Logo"
                    class="w-11 h-11 object-contain" loading="eager">
                <span class="text-xl font-bold text-white">light star media</span>
            </a>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md px-6 py-8 bg-navy-card/80 backdrop-blur-xl border border-navy-border shadow-2xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>