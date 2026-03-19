<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio — Light Star</title>
    <meta name="description"
        content="Dokumentasi lengkap portofolio acara Light Star. Lihat koleksi video live streaming, wedding, corporate event, dan dokumentasi profesional kami.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-navy text-white font-inter antialiased">

    {{-- ═══ HEADER ═══ --}}
    <header class="fixed top-0 left-0 right-0 z-50 transition-all duration-500 ease-in-out nav-scrolled">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-2 sm:gap-3">
                    <div class="w-8 sm:w-10 h-8 sm:h-10 bg-cyan rounded-lg sm:rounded-xl flex items-center justify-center">
                        <svg class="w-5 sm:w-6 h-5 sm:h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path
                                d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z" />
                        </svg>
                    </div>
                    <span class="text-lg sm:text-xl font-bold">Light <span class="text-cyan">Star</span></span>
                </a>
                <nav class="hidden sm:flex items-center gap-4 sm:gap-6">
                    <a href="{{ route('home') }}"
                        class="text-slate-text hover:text-white transition-colors text-xs sm:text-sm font-medium">← Kembali ke Beranda</a>
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn-cyan text-xs sm:text-sm px-4 sm:px-5 py-2"><span>Dashboard</span></a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-cyan text-xs sm:text-sm px-4 sm:px-5 py-2"><span>Sign In</span></a>
                    @endauth
                </nav>
                <button id="mobile-menu-portfolio" class="sm:hidden flex flex-col gap-1 p-2 hover:bg-white/10 rounded-lg transition-colors">
                    <span class="block w-5 h-0.5 bg-white transition-all duration-300"></span>
                    <span class="block w-5 h-0.5 bg-white transition-all duration-300"></span>
                    <span class="block w-5 h-0.5 bg-white transition-all duration-300"></span>
                </button>
            </div>

            <div class="sm:hidden pb-3">
                <a href="{{ route('home') }}"
                    class="inline-flex items-center justify-center w-full px-4 py-2.5 rounded-xl border border-navy-border bg-navy-card/70 text-slate-heading text-xs font-semibold hover:text-cyan hover:border-cyan/40 transition-colors">
                    ← Kembali ke Beranda
                </a>
            </div>

            <!-- Mobile menu -->
            <div id="mobile-menu-portfolio-content" class="hidden sm:hidden pb-4 pt-2">
                <div class="flex flex-col gap-2 bg-navy-card/95 backdrop-blur-xl rounded-xl p-4 border border-navy-border">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn-cyan text-xs text-center px-3 py-2"><span>Dashboard</span></a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-cyan text-xs text-center px-3 py-2"><span>Sign In</span></a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ PAGE CONTENT ═══ --}}
    <main class="pt-24 sm:pt-32 pb-16 sm:pb-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Page Header --}}
            <div class="mb-12 sm:mb-16 fade-up">
                <div class="section-divider mb-4 sm:mb-6"></div>
                <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 sm:mb-4">Seluruh <span
                        class="text-cyan">Portofolio</span></h1>
                <p class="text-slate-text text-sm sm:text-base md:text-lg max-w-2xl">Koleksi lengkap dokumentasi dan video acara yang pernah
                    kami tangani. Dari webinar, pernikahan, hingga corporate event.</p>
            </div>

            {{-- Portfolio Grid --}}
            @if($portfolios->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6 mb-12">
                    @foreach($portfolios as $item)
                        <div class="portfolio-card fade-up">
                            <div class="portfolio-img-wrapper relative overflow-hidden">
                                <img src="{{ str_starts_with($item->thumbnail, 'assets/') ? asset($item->thumbnail) : asset('storage/' . $item->thumbnail) }}"
                                    alt="{{ $item->title }}" class="w-full h-40 sm:h-52 object-cover">
                                @if ($item->video_url)
                                    <a href="{{ $item->video_url }}" target="_blank" class="portfolio-overlay">
                                        <div
                                            class="w-10 sm:w-12 h-10 sm:h-12 rounded-full bg-cyan/90 backdrop-blur-sm flex items-center justify-center shadow-lg shadow-cyan/30 transition-transform duration-300 hover:scale-110">
                                            <svg class="w-4 sm:w-5 h-4 sm:h-5 text-white ml-0.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                            </svg>
                                        </div>
                                    </a>
                                @endif
                            </div>
                            <div class="px-2.5 sm:px-3 py-2.5 sm:py-3">
                                <h3 class="text-cyan font-semibold text-xs sm:text-sm mb-1">{{ $item->title }}</h3>
                                @if ($item->description)
                                    <p class="text-slate-text text-xs leading-relaxed line-clamp-2">{{ $item->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="flex justify-center">
                    {{ $portfolios->links('pagination::tailwind') }}
                </div>
            @else
                <div class="text-center py-16 sm:py-24">
                    <svg class="w-12 sm:w-16 h-12 sm:h-16 text-slate-text/30 mx-auto mb-4 sm:mb-6" fill="none" stroke="currentColor"
                        stroke-width="1.5" viewBox="0 0 24 24">
                        <path
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v13.5A1.5 1.5 0 003.75 21z" />
                    </svg>
                    <h3 class="text-white text-lg sm:text-xl font-semibold mb-2">Belum ada portofolio</h3>
                    <p class="text-slate-text text-sm sm:text-base">Portofolio akan segera hadir.</p>
                </div>
            @endif
        </div>
    </main>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="border-t border-navy-border py-6 sm:py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-slate-text text-xs sm:text-sm">&copy; {{ date('Y') }} Light Star. All rights reserved.</p>
        </div>
    </footer>

</body>

</html>