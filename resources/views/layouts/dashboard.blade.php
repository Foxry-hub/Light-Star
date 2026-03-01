<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard — Light Star</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased bg-navy text-slate-text font-sans">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside id="sidebar"
            class="fixed inset-y-0 left-0 w-64 bg-navy-card border-r border-navy-border z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
            <div class="flex items-center gap-3 px-6 h-20 border-b border-navy-border">
                <div
                    class="w-9 h-9 rounded-lg bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                    </svg>
                </div>
                <span class="text-lg font-bold text-white">Light <span class="text-cyan">Star</span></span>
            </div>
            <nav class="p-4 space-y-1">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-cyan/10 text-cyan' : 'text-slate-text hover:bg-navy-border/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path
                            d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.testimonials.*') ? 'bg-cyan/10 text-cyan' : 'text-slate-text hover:bg-navy-border/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path
                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                    Testimoni
                </a>
                <a href="{{ route('admin.portfolios.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.portfolios.*') ? 'bg-cyan/10 text-cyan' : 'text-slate-text hover:bg-navy-border/50 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                    Portofolio
                </a>

                <div class="pt-4 mt-4 border-t border-navy-border">
                    <a href="{{ route('home') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-text hover:bg-navy-border/50 hover:text-white transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                            <path
                                d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                        Kembali ke Website
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-text hover:bg-red-500/10 hover:text-red-400 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path
                                    d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>
            </nav>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 lg:ml-64">
            {{-- Top Bar --}}
            <header
                class="sticky top-0 z-30 bg-navy/80 backdrop-blur-xl border-b border-navy-border h-16 flex items-center px-4 lg:px-8">
                <button id="sidebar-toggle" class="lg:hidden p-2 text-slate-text hover:text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <div class="flex-1"></div>
                <div class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center text-white text-sm font-bold">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <span class="text-sm text-white font-medium hidden sm:block">{{ auth()->user()->name }}</span>
                </div>
            </header>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div
                    class="mx-4 lg:mx-8 mt-4 bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Page Content --}}
            <main class="p-4 lg:p-8">
                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Sidebar toggle for mobile
        const sidebarToggle = document.getElementById('sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        if (sidebarToggle && sidebar) {
            sidebarToggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>

</html>