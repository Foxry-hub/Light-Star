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
                <div
                    class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <span class="text-xl font-bold text-white">Light <span class="text-cyan">Star</span></span>
            </a>
        </div>

        <div
            class="relative z-10 w-full sm:max-w-md px-6 py-8 bg-navy-card/80 backdrop-blur-xl border border-navy-border shadow-2xl overflow-hidden sm:rounded-2xl">
            {{ $slot }}
        </div>
    </div>
</body>

</html>