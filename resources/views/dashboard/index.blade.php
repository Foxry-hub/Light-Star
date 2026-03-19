@extends('layouts.dashboard')
@section('content')
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl font-bold text-white">Dashboard</h1>
        <p class="text-slate-text text-sm mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-cyan/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-cyan" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path
                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5A2.25 2.25 0 0022.5 18.75V5.25A2.25 2.25 0 0020.25 3H3.75A2.25 2.25 0 001.5 5.25v13.5A2.25 2.25 0 003.75 21z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['total_portfolios'] }}</div>
            <div class="text-sm text-slate-text mt-1">Total Portofolio</div>
        </div>

        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['approved_testimonials'] }}</div>
            <div class="text-sm text-slate-text mt-1">Testimoni Approved</div>
        </div>

        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['pending_testimonials'] }}</div>
            <div class="text-sm text-slate-text mt-1">Testimoni Pending</div>
        </div>

        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path
                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['total_testimonials'] }}</div>
            <div class="text-sm text-slate-text mt-1">Total Testimoni</div>
        </div>
    </div>

    {{-- Recent Items --}}
    <div class="grid lg:grid-cols-2 gap-4 sm:gap-6">
        {{-- Recent Portfolios --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-white">Portofolio Terbaru</h2>
                <a href="{{ route('admin.portfolios.index') }}"
                    class="text-cyan text-sm hover:text-cyan-light transition-colors">Lihat Semua</a>
            </div>
            <div class="md:hidden space-y-3">
                @forelse($recentPortfolios as $p)
                    <div class="rounded-xl border border-navy-border bg-navy/30 p-3">
                        <div class="flex items-start gap-3 min-w-0">
                            <img src="{{ str_starts_with($p->thumbnail, 'assets/') ? asset($p->thumbnail) : asset('storage/' . $p->thumbnail) }}"
                                alt="{{ $p->title }}" class="w-14 h-14 rounded-lg object-cover shrink-0">
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-medium text-white leading-snug line-clamp-2 break-words">{{ $p->title }}</div>
                                <div class="text-xs text-slate-text mt-1">{{ $p->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-text text-sm">Belum ada portofolio.</p>
                @endforelse
            </div>
            <div class="hidden md:block">
            @forelse($recentPortfolios as $p)
                <div class="flex items-center gap-4 py-3 {{ !$loop->last ? 'border-b border-navy-border' : '' }}">
                    <img src="{{ str_starts_with($p->thumbnail, 'assets/') ? asset($p->thumbnail) : asset('storage/' . $p->thumbnail) }}"
                        alt="{{ $p->title }}" class="w-12 h-12 rounded-lg object-cover">
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-white truncate">{{ $p->title }}</div>
                        <div class="text-xs text-slate-text">{{ $p->created_at->diffForHumans() }}</div>
                    </div>
                </div>
            @empty
                <p class="text-slate-text text-sm">Belum ada portofolio.</p>
            @endforelse
            </div>
        </div>

        {{-- Recent Testimonials --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-semibold text-white">Testimoni Terbaru</h2>
                <a href="{{ route('admin.testimonials.index') }}"
                    class="text-cyan text-sm hover:text-cyan-light transition-colors">Lihat Semua</a>
            </div>
            <div class="md:hidden space-y-3">
                @forelse($recentTestimonials as $t)
                    <div class="rounded-xl border border-navy-border bg-navy/30 p-3">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <span class="text-sm font-medium text-white truncate">{{ $t->name }}</span>
                            <span
                                class="text-[11px] px-2 py-1 rounded-full shrink-0 {{ $t->is_approved ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                {{ $t->is_approved ? 'Approved' : 'Pending' }}
                            </span>
                        </div>
                        <p class="text-xs text-slate-text leading-relaxed line-clamp-3 break-words">{{ $t->content }}</p>
                    </div>
                @empty
                    <p class="text-slate-text text-sm">Belum ada testimoni.</p>
                @endforelse
            </div>
            <div class="hidden md:block">
            @forelse($recentTestimonials as $t)
                <div class="py-3 {{ !$loop->last ? 'border-b border-navy-border' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="text-sm font-medium text-white">{{ $t->name }}</span>
                        <span
                            class="text-xs px-2 py-1 rounded-full {{ $t->is_approved ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                            {{ $t->is_approved ? 'Approved' : 'Pending' }}
                        </span>
                    </div>
                    <p class="text-xs text-slate-text truncate">{{ $t->content }}</p>
                </div>
            @empty
                <p class="text-slate-text text-sm">Belum ada testimoni.</p>
            @endforelse
            </div>
        </div>
    </div>
@endsection