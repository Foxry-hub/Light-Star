<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="Light Star — Kru Broadcast Profesional Anda. Jasa Operator Live Streaming & Dokumentasi Profesional.">
    <meta name="keywords" content="live streaming, broadcast, videografi, produksi video, dokumentasi acara">
    <meta name="author" content="Light Star">
    <title>Light Star — Kru Broadcast Profesional Anda</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased">

    {{-- ═══ FLOATING WHATSAPP ═══ --}}
    <a href="https://wa.me/6281388088171" target="_blank" class="whatsapp-float" aria-label="Chat WhatsApp">
        <svg class="w-7 h-7" fill="currentColor" viewBox="0 0 24 24">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
        </svg>
    </a>

    {{-- ═══ HEADER ═══ --}}
    <header id="main-header" class="fixed top-0 left-0 right-0 z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <a href="#beranda" class="flex items-center gap-3">
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
                <nav class="hidden md:flex items-center gap-8">
                    <a href="#beranda"
                        class="nav-link text-sm font-medium text-slate-heading hover:text-cyan transition-colors">Beranda</a>
                    <a href="#layanan"
                        class="nav-link text-sm font-medium text-slate-text hover:text-cyan transition-colors">Layanan</a>
                    <a href="#portofolio"
                        class="nav-link text-sm font-medium text-slate-text hover:text-cyan transition-colors">Portofolio</a>
                    <a href="#faq"
                        class="nav-link text-sm font-medium text-slate-text hover:text-cyan transition-colors">FAQ</a>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="btn-cyan text-sm"><span>Dashboard</span></a>
                        @else
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit"
                                    class="text-sm font-medium text-slate-text hover:text-cyan transition-colors">Logout</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-cyan text-sm"><span>Sign In</span></a>
                    @endauth
                </nav>
                <button id="mobile-menu-btn" class="md:hidden flex flex-col gap-1.5 p-2">
                    <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
                    <span class="block w-6 h-0.5 bg-white transition-all duration-300"></span>
                </button>
            </div>
            <div id="mobile-menu" class="hidden md:hidden pb-6">
                <div
                    class="flex flex-col gap-4 bg-navy-card/80 backdrop-blur-xl rounded-2xl p-6 border border-navy-border">
                    <a href="#beranda"
                        class="text-sm font-medium text-slate-heading hover:text-cyan transition-colors">Beranda</a>
                    <a href="#layanan"
                        class="text-sm font-medium text-slate-text hover:text-cyan transition-colors">Layanan</a>
                    <a href="#portofolio"
                        class="text-sm font-medium text-slate-text hover:text-cyan transition-colors">Portofolio</a>
                    <a href="#faq" class="text-sm font-medium text-slate-text hover:text-cyan transition-colors">FAQ</a>
                    @auth
                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}"
                                class="btn-cyan text-sm text-center"><span>Dashboard</span></a>
                        @else
                            <form method="POST" action="{{ route('logout') }}">@csrf
                                <button type="submit"
                                    class="text-sm font-medium text-slate-text hover:text-cyan transition-colors">Logout</button>
                            </form>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn-cyan text-sm text-center"><span>Sign
                                In</span></a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ HERO SECTION ═══ --}}
    <section id="beranda" class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('assets/images/hero-bg.png') }}" alt="Cityscape" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-navy/80 via-navy/70 to-navy"></div>
        </div>
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-cyan/5 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-72 h-72 bg-cyan/5 rounded-full blur-3xl"></div>
        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center py-32">
            <div
                class="inline-flex items-center gap-2 bg-cyan/10 border border-cyan/20 rounded-full px-4 py-2 mb-8 fade-up">
                <span class="w-2 h-2 rounded-full bg-cyan pulse-dot"></span>
                <span class="text-cyan text-sm font-medium">Siap Melayani 24/7</span>
            </div>
            <h1 class="text-4xl sm:text-5xl md:text-7xl font-black text-white leading-tight mb-6 fade-up">
                Kru Broadcast<br><span class="gradient-text">Profesional Anda.</span>
            </h1>
            <p class="text-lg sm:text-xl text-slate-text max-w-2xl mx-auto mb-10 leading-relaxed fade-up">
                Jasa Operator Live Streaming & Dokumentasi Profesional.<br class="hidden sm:block">
                Fokus pada acara Anda, biarkan tim ahli kami menangani seluruh teknis penyiaran.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center fade-up">
                <a href="https://wa.me/6281388088171" target="_blank" class="btn-cyan text-base px-8 py-4"><span>Mulai
                        Konsultasi Gratis</span></a>
                <a href="#portofolio"
                    class="border border-navy-border text-white font-semibold px-8 py-4 rounded-xl hover:border-cyan hover:text-cyan transition-all">Lihat
                    Portofolio</a>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-20 fade-up">
                <div class="text-center">
                    <div class="text-3xl font-bold text-white"><span class="counter" data-target="150">0</span>+
                    </div>
                    <div class="text-sm text-slate-text mt-1">Acara Ditangani</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white"><span class="counter" data-target="50">0</span>+
                    </div>
                    <div class="text-sm text-slate-text mt-1">Klien Puas</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white"><span class="counter" data-target="5">0</span>+
                    </div>
                    <div class="text-sm text-slate-text mt-1">Tahun Pengalaman</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-white"><span class="counter" data-target="20">0</span>+
                    </div>
                    <div class="text-sm text-slate-text mt-1">Kru Profesional</div>
                </div>
            </div>
        </div>
        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 float-animation">
            <svg class="w-6 h-6 text-cyan" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M19 14l-7 7m0 0l-7-7m7 7V3" />
            </svg>
        </div>
    </section>

    {{-- ═══ ABOUT US ═══ --}}
    <section id="tentang" class="py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
                <div class="fade-left">
                    <div class="relative">
                        <div
                            class="absolute -inset-4 bg-gradient-to-r from-cyan/20 to-transparent rounded-2xl blur-2xl">
                        </div>
                        <img src="{{ asset('assets/images/team-photo.png') }}" alt="Tim Light Star"
                            class="relative rounded-2xl w-full object-cover shadow-2xl border border-navy-border">
                    </div>
                </div>
                <div class="fade-right">
                    <div class="section-divider mb-6"></div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">About <span class="text-cyan">Us</span>
                    </h2>
                    <p class="text-slate-text leading-relaxed mb-6"><strong class="text-white">Light Star</strong>
                        adalah partner teknis terpercaya Anda dalam dunia penyiaran digital. Kami hadir bukan hanya
                        sebagai penyedia jasa, tetapi sebagai mitra yang memahami kebutuhan teknis acara Anda secara
                        mendalam.</p>
                    <p class="text-slate-text leading-relaxed mb-8">Dengan pengalaman bertahun-tahun, tim kami mampu
                        mengelola peralatan klien dan mengubahnya menjadi hasil karya profesional yang memukau. Dari
                        setup sederhana hingga produksi multi-kamera yang kompleks, kami siap menghadirkan kualitas
                        broadcast terbaik.</p>
                    <div class="flex flex-wrap gap-4">
                        @foreach (['Multi-Platform', 'Tim Berpengalaman', 'Peralatan Profesional'] as $tag)
                            <div class="flex items-center gap-2 bg-cyan/10 rounded-lg px-4 py-2">
                                <svg class="w-5 h-5 text-cyan" fill="none" stroke="currentColor" stroke-width="2"
                                    viewBox="0 0 24 24">
                                    <path d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-sm text-white">{{ $tag }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ OUR SERVICES (Photo cards with hover text) ═══ --}}
    <section id="layanan" class="py-24 lg:py-32 bg-navy-light/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-up">
                <div class="section-divider mx-auto mb-6"></div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Layanan <span class="text-cyan">Kami</span>
                </h2>
                <p class="text-slate-text max-w-xl mx-auto">Solusi lengkap untuk kebutuhan broadcast dan produksi
                    video profesional Anda.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-8 stagger-children">
                @php
                    $services = [
                        [
                            'img' => 'service-livestreaming.png',
                            'title' => 'Operator Live Streaming',
                            'desc' =>
                                'Ahli setup multi-platform streaming di Zoom, YouTube, Instagram, dan platform lainnya. Kami memastikan siaran berjalan stabil dengan kualitas audio visual terbaik.',
                        ],
                        [
                            'img' => 'service-production.png',
                            'title' => 'Kru Produksi',
                            'desc' =>
                                'Penyediaan cameraman dan audio engineer profesional yang berpengalaman menangani berbagai jenis acara, dari seminar hingga konser besar.',
                        ],
                        [
                            'img' => 'service-postproduction.png',
                            'title' => 'Pasca-Produksi',
                            'desc' =>
                                'Jasa editing video, color grading, dan motion graphic berkualitas tinggi. Kami mengubah rekaman mentah menjadi konten yang siap dipublikasikan.',
                        ],
                    ];
                @endphp
                @foreach ($services as $svc)
                    <div class="service-card fade-up">
                        <img src="{{ asset('assets/images/' . $svc['img']) }}" alt="{{ $svc['title'] }}">
                        <div class="service-overlay">
                            <h3 class="text-xl font-bold text-white mb-2">{{ $svc['title'] }}</h3>
                            <div class="service-description">
                                <p class="text-slate-text text-sm leading-relaxed">{{ $svc['desc'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ WHY CHOOSE US ═══ --}}
    <section class="py-24 lg:py-32">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="relative bg-gradient-to-br from-navy-card to-navy-light rounded-3xl border border-navy-border p-8 sm:p-12 lg:p-16 overflow-hidden fade-up">
                <div
                    class="absolute top-0 right-0 w-96 h-96 bg-cyan/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
                </div>
                <div class="relative z-10">
                    <div class="section-divider mb-6"></div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white mb-6">Mengapa Memilih <span
                            class="text-cyan">Kami?</span></h2>
                    <p class="text-slate-text text-lg leading-relaxed max-w-3xl">Kami menghadirkan tenaga ahli
                        spesialis yang mahir mengoperasikan berbagai platform siaran digital. Tim kami dibekali
                        kemampuan teknis untuk menangani kendala perangkat secara instan, memastikan acara Anda
                        berjalan lancar. Dengan pendekatan yang profesional dan responsif, setiap detail teknis akan
                        kami kelola sehingga Anda bisa fokus sepenuhnya pada konten dan audiens.</p>
                    <div class="grid sm:grid-cols-3 gap-8 mt-12">
                        @php
                            $features = [
                                [
                                    'icon' => 'M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z',
                                    'title' => 'Respons Cepat',
                                    'desc' => 'Troubleshooting instan tanpa gangguan siaran.',
                                ],
                                [
                                    'icon' =>
                                        'M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z',
                                    'title' => 'Terpercaya',
                                    'desc' => 'Dipercaya ratusan klien dari berbagai industri.',
                                ],
                                [
                                    'icon' =>
                                        'M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z',
                                    'title' => 'Kualitas Terbaik',
                                    'desc' => 'Standar broadcast profesional di setiap project.',
                                ],
                            ];
                        @endphp
                        @foreach ($features as $f)
                            <div class="flex items-start gap-4">
                                <div class="w-12 h-12 rounded-xl bg-cyan/10 flex items-center justify-center shrink-0">
                                    <svg class="w-6 h-6 text-cyan" fill="none" stroke="currentColor" stroke-width="1.5"
                                        viewBox="0 0 24 24">
                                        <path d="{{ $f['icon'] }}" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-white font-semibold mb-1">{{ $f['title'] }}</h3>
                                    <p class="text-slate-text text-sm">{{ $f['desc'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ PORTOFOLIO (Dynamic, no labels) ═══ --}}
    <section id="portofolio" class="py-24 lg:py-32 bg-navy-light/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-16 fade-up">
                <div>
                    <div class="section-divider mb-6"></div>
                    <h2 class="text-3xl sm:text-4xl font-bold text-white">Portofolio <span
                            class="text-cyan">Acara</span></h2>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-children">
                @forelse($portfolios as $item)
                    <div class="portfolio-card fade-up">
                        <img src="{{ str_starts_with($item->thumbnail, 'assets/') ? asset($item->thumbnail) : asset('storage/' . $item->thumbnail) }}"
                            alt="{{ $item->title }}" class="w-full h-64 object-cover">
                        <div class="portfolio-overlay">
                            <h3 class="text-white font-semibold text-sm mb-2">{{ $item->title }}</h3>
                            @if ($item->video_url)
                                <a href="{{ $item->video_url }}" target="_blank"
                                    class="inline-flex items-center gap-2 text-cyan text-sm font-medium hover:text-cyan-light transition-colors">
                                    Tonton Cuplikan
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path
                                            d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-16">
                        <p class="text-slate-text">Portofolio segera hadir.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ TESTIMONI (Dynamic) ═══ --}}
    <section class="py-24 lg:py-32">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16 fade-up">
                <div class="section-divider mx-auto mb-6"></div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Cerita Kebahagiaan <span
                        class="text-cyan">Klien</span></h2>
            </div>
            @if ($testimonials->count() > 0)
                <div class="relative fade-up">
                    <div class="overflow-hidden rounded-2xl">
                        <div id="testimonial-track" class="testimonial-track">
                            @foreach ($testimonials as $t)
                                <div class="testimonial-slide">
                                    <div class="bg-navy-card border border-navy-border rounded-2xl p-8 sm:p-10 text-center">
                                        <svg class="w-10 h-10 text-cyan/30 mx-auto mb-6" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path
                                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10H14.017zM0 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151C7.546 6.068 5.983 8.789 5.983 11h4v10H0z" />
                                        </svg>
                                        <p class="text-slate-text text-lg leading-relaxed mb-8">"{{ $t->content }}"</p>
                                        <div
                                            class="w-12 h-12 rounded-full bg-gradient-to-br from-cyan to-cyan-dark mx-auto mb-3 flex items-center justify-center text-white font-bold text-lg">
                                            {{ substr($t->name, 0, 1) }}
                                        </div>
                                        <h4 class="text-white font-semibold">{{ $t->name }}</h4>
                                        <p class="text-cyan text-sm">{{ $t->role_label }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex items-center justify-center gap-4 mt-8">
                        <button id="carousel-prev"
                            class="w-10 h-10 rounded-full border border-navy-border hover:border-cyan text-slate-text hover:text-cyan transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15.75 19.5L8.25 12l7.5-7.5" />
                            </svg>
                        </button>
                        <div class="flex gap-2">
                            @foreach ($testimonials as $i => $t)
                                <button
                                    class="carousel-dot {{ $i === 0 ? 'w-8 bg-cyan' : 'w-3 bg-navy-border' }} h-3 rounded-full transition-all"></button>
                            @endforeach
                        </div>
                        <button id="carousel-next"
                            class="w-10 h-10 rounded-full border border-navy-border hover:border-cyan text-slate-text hover:text-cyan transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                            </svg>
                        </button>
                    </div>
                </div>
            @else
                <p class="text-center text-slate-text">Testimoni segera hadir.</p>
            @endif
        </div>
    </section>

    {{-- ═══ TESTIMONIAL SUBMISSION FORM ═══ --}}
    <section class="py-24 lg:py-32 bg-navy-light/50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Success Message --}}
            @if (session('testimonial_success'))
                <div class="mb-8 bg-cyan/10 border border-cyan/30 rounded-2xl p-5 flex items-center gap-3 fade-up">
                    <svg class="w-6 h-6 text-cyan shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-cyan text-sm font-medium">{{ session('testimonial_success') }}</p>
                </div>
            @endif

            {{-- Section Title --}}
            <div class="mb-12 fade-up">
                <div class="section-divider mb-6"></div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white">Bagikan <span class="text-cyan">Pengalaman
                        Anda</span></h2>
                <p class="text-slate-text mt-3">Ceritakan kesan Anda bekerja sama dengan Light Star. Testimoni Anda
                    sangat berarti bagi kami!</p>
            </div>

            {{-- Split Layout: Illustration + Form --}}
            <div class="grid lg:grid-cols-2 gap-10 items-stretch fade-up">
                {{-- Left: Illustration --}}
                <div class="relative rounded-2xl overflow-hidden border border-navy-border bg-navy-card min-h-[350px]">
                    <img src="{{ asset('assets/images/testimonial-illustration.png') }}" alt="Share your story"
                        class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent"></div>
                    <div class="absolute bottom-6 left-6 right-6">
                        <div class="flex items-center gap-3">
                            <div class="flex -space-x-2">
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center text-white text-xs font-bold border-2 border-navy-card">
                                    😊</div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-xs font-bold border-2 border-navy-card">
                                    🎉</div>
                                <div
                                    class="w-8 h-8 rounded-full bg-gradient-to-br from-yellow-400 to-orange-500 flex items-center justify-center text-white text-xs font-bold border-2 border-navy-card">
                                    ⭐</div>
                            </div>
                            <span class="text-white text-sm font-medium">Bergabung dengan klien puas lainnya!</span>
                        </div>
                    </div>
                </div>

                {{-- Right: Form --}}
                <form action="{{ route('testimonial.store') }}" method="POST" class="flex flex-col gap-5">
                    @csrf
                    <div>
                        <label for="testi-name" class="block text-sm font-medium text-slate-heading mb-2">Nama
                            Lengkap</label>
                        <input type="text" id="testi-name" name="name"
                            value="{{ old('name', auth()->user()->name ?? '') }}" required
                            placeholder="Masukkan nama Anda" class="newsletter-input w-full text-sm">
                        @error('name')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label for="testi-role" class="block text-sm font-medium text-slate-heading mb-2">Jabatan /
                            Peran</label>
                        <input type="text" id="testi-role" name="role_label" value="{{ old('role_label') }}" required
                            placeholder="cth: Event Organizer, Wedding Planner" class="newsletter-input w-full text-sm">
                        @error('role_label')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex-1">
                        <label for="testi-content" class="block text-sm font-medium text-slate-heading mb-2">Kesan &
                            Pesan</label>
                        <textarea id="testi-content" name="content" rows="5" required
                            placeholder="Ceritakan pengalaman Anda bekerja sama dengan Light Star..."
                            class="newsletter-input w-full text-sm resize-none">{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <button type="submit" class="btn-cyan text-sm px-8 py-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M6 12L3.269 3.126A59.768 59.768 0 0121.485 12 59.77 59.77 0 013.27 20.876L5.999 12zm0 0h7.5" />
                            </svg>
                            <span>Kirim Testimoni</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    {{-- ═══ FAQ ═══ --}}
    <section id="faq" class="py-24 lg:py-32 bg-navy-light/50">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 fade-up">
                <div class="section-divider mx-auto mb-6"></div>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">Pertanyaan yang Sering <span
                        class="text-cyan">Diajukan</span></h2>
            </div>
            <div class="mb-8 fade-up">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-slate-text" fill="none"
                        stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <input id="faq-search" type="text" placeholder="Cari pertanyaan..."
                        class="newsletter-input w-full pl-12">
                </div>
            </div>
            <div class="space-y-4 fade-up">
                @php
                    $faqs = [
                        [
                            'q' => 'Bagaimana cara memesan jasa Light Star?',
                            'a' =>
                                'Anda bisa menghubungi kami melalui WhatsApp di 0813-8808-8171 atau klik tombol "Konsultasi Gratis" di website ini. Tim kami akan merespons dalam waktu maksimal 1 jam.',
                        ],
                        [
                            'q' => 'Berapa biaya jasa live streaming?',
                            'a' =>
                                'Biaya bervariasi tergantung kebutuhan acara, jumlah kamera, platform streaming, dan durasi. Hubungi kami untuk mendapatkan penawaran yang disesuaikan dengan budget Anda.',
                        ],
                        [
                            'q' => 'Apakah bisa streaming ke beberapa platform sekaligus?',
                            'a' =>
                                'Tentu! Kami mendukung multi-platform streaming ke YouTube, Instagram, Zoom, Facebook, dan platform lainnya secara bersamaan tanpa penurunan kualitas.',
                        ],
                        [
                            'q' => 'Apakah Light Star menyediakan peralatan?',
                            'a' =>
                                'Ya, kami menyediakan full equipment termasuk kamera, audio mixer, lighting, switcher, dan perangkat streaming. Kami juga bisa menggunakan peralatan milik klien jika dibutuhkan.',
                        ],
                        [
                            'q' => 'Berapa lama waktu persiapan sebelum acara?',
                            'a' =>
                                'Untuk setup standar, kami memerlukan 2-3 jam sebelum acara dimulai. Untuk produksi yang lebih kompleks, kami akan melakukan technical rehearsal sehari sebelumnya.',
                        ],
                    ];
                @endphp
                @foreach ($faqs as $faq)
                    <div class="faq-item">
                        <div class="faq-header">
                            <span class="text-white font-medium text-sm pr-4">{{ $faq['q'] }}</span>
                            <svg class="faq-icon w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                        </div>
                        <div class="faq-body">
                            <div class="px-6 pb-5 text-slate-text text-sm leading-relaxed">{{ $faq['a'] }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ═══ FOOTER ═══ --}}
    <footer class="border-t border-navy-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid md:grid-cols-3 gap-12">
                <div>
                    <div class="flex items-center gap-3 mb-6">
                        <div
                            class="w-10 h-10 rounded-xl bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24">
                                <path
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <span class="text-xl font-bold text-white">Light <span class="text-cyan">Star</span></span>
                    </div>
                    <p class="text-slate-text text-sm leading-relaxed mb-6">Kru broadcast profesional yang siap
                        membantu Anda menghadirkan acara berkualitas tinggi melalui layanan live streaming dan
                        dokumentasi.</p>
                    <a href="https://wa.me/6281388088171" target="_blank"
                        class="inline-flex items-center gap-2 text-cyan hover:text-cyan-light transition-colors text-sm">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z" />
                        </svg>
                        0813-8808-8171
                    </a>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Peta Situs</h3>
                    <ul class="space-y-3">
                        <li><a href="#beranda"
                                class="text-slate-text hover:text-cyan text-sm transition-colors">Beranda</a></li>
                        <li><a href="#tentang" class="text-slate-text hover:text-cyan text-sm transition-colors">Tentang
                                Kami</a></li>
                        <li><a href="#layanan"
                                class="text-slate-text hover:text-cyan text-sm transition-colors">Layanan</a></li>
                        <li><a href="#portofolio"
                                class="text-slate-text hover:text-cyan text-sm transition-colors">Portofolio</a></li>
                        <li><a href="#faq" class="text-slate-text hover:text-cyan text-sm transition-colors">FAQ</a>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-6">Ikuti Kami</h3>
                    <div class="flex gap-3 mb-8">
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-navy-card border border-navy-border hover:border-cyan hover:text-cyan text-slate-text transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-navy-card border border-navy-border hover:border-cyan hover:text-cyan text-slate-text transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                            </svg>
                        </a>
                        <a href="#"
                            class="w-10 h-10 rounded-xl bg-navy-card border border-navy-border hover:border-cyan hover:text-cyan text-slate-text transition-all flex items-center justify-center">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path
                                    d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z" />
                            </svg>
                        </a>
                    </div>
                    <h3 class="text-white font-semibold mb-4">Newsletter</h3>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email Anda" class="newsletter-input flex-1 text-sm">
                        <button type="submit" class="btn-cyan text-sm px-4"><span>Kirim</span></button>
                    </form>
                </div>
            </div>
            <div class="border-t border-navy-border mt-12 pt-8 text-center">
                <p class="text-slate-text text-sm">&copy; {{ date('Y') }} Light Star. All rights reserved.</p>
            </div>
        </div>
    </footer>

</body>

</html>