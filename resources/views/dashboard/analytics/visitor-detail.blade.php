@extends('layouts.dashboard')

@section('content')
    <div class="mb-6 sm:mb-8">
        <a href="{{ route('admin.analytics.active-visitors') }}" class="text-cyan hover:text-cyan-light mb-4 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Pengunjung Aktif
        </a>
        <h1 class="text-2xl font-bold text-white">Detail Pengunjung</h1>
        <p class="text-slate-text text-sm mt-1">Informasi lengkap dan riwayat kunjungan pengunjung</p>
    </div>

    {{-- Visitor Info Card --}}
    <div class="bg-navy-card border border-navy-border rounded-2xl p-6 mb-6 sm:mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Left Column --}}
            <div>
                <h3 class="text-lg font-semibold text-white mb-6">Informasi Pengunjung</h3>
                <div class="space-y-4">
                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">Nama/Status</p>
                        <p class="text-white font-medium">{{ $visitor->user?->name ?? 'Pengunjung Anonymous' }}</p>
                    </div>

                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">Session ID</p>
                        <p class="text-white font-mono text-xs break-all">{{ $visitor->session_id }}</p>
                    </div>

                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">IP Address</p>
                        <p class="text-white font-mono">{{ $visitor->visitor_ip }}</p>
                    </div>

                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">Device</p>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="text-lg">
                                @if ($visitor->device_type === 'mobile')
                                    📱
                                @elseif ($visitor->device_type === 'tablet')
                                    📱
                                @else
                                    🖥️
                                @endif
                            </span>
                            <span class="text-white font-medium capitalize">{{ $visitor->device_type }}</span>
                        </div>
                    </div>

                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">Browser</p>
                        <p class="text-white font-medium">{{ $visitor->browser ?? '-' }}</p>
                    </div>

                    <div class="pb-4 border-b border-navy-border">
                        <p class="text-sm text-slate-text mb-1">OS</p>
                        <p class="text-white font-medium">{{ $visitor->os ?? '-' }}</p>
                    </div>

                    @if ($visitor->country || $visitor->city)
                        <div class="pb-4 border-b border-navy-border">
                            <p class="text-sm text-slate-text mb-1">Lokasi</p>
                            <p class="text-white font-medium">
                                {{ $visitor->city }}{{ $visitor->country ? ', ' . $visitor->country : '' }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Right Column - Activity Stats --}}
            <div>
                <h3 class="text-lg font-semibold text-white mb-6">Statistik Kunjungan</h3>
                <div class="space-y-4">
                    <div class="bg-navy/30 rounded-lg p-4 border border-navy-border">
                        <p class="text-sm text-slate-text mb-2">Total Page Views</p>
                        <p class="text-3xl font-bold text-cyan">{{ $visitor->page_views_count }}</p>
                    </div>

                    <div class="bg-navy/30 rounded-lg p-4 border border-navy-border">
                        <p class="text-sm text-slate-text mb-2">Kunjungan Pertama</p>
                        <p class="text-white font-medium">{{ $visitor->first_visit_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</p>
                        <p class="text-xs text-slate-text mt-1">{{ $visitor->first_visit_at->diffForHumans() }}</p>
                    </div>

                    <div class="bg-navy/30 rounded-lg p-4 border border-navy-border">
                        <p class="text-sm text-slate-text mb-2">Kunjungan Terakhir</p>
                        <p class="text-white font-medium">{{ $visitor->last_visit_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</p>
                        <p class="text-xs text-slate-text mt-1">{{ $visitor->last_visit_at->diffForHumans() }}</p>
                    </div>

                    <div class="bg-navy/30 rounded-lg p-4 border border-navy-border">
                        <p class="text-sm text-slate-text mb-2">Aktivitas Terakhir</p>
                        <p class="text-white font-medium">{{ $visitor->last_activity_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }} WIB</p>
                        <p class="text-xs text-slate-text mt-1">{{ $visitor->last_activity_at->diffForHumans() }}</p>
                    </div>

                    <div class="bg-navy/30 rounded-lg p-4 border border-navy-border">
                        <p class="text-sm text-slate-text mb-2">Status</p>
                        @if ($visitor->isActive())
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                <span class="text-green-400 font-semibold">Aktif</span>
                            </div>
                        @else
                            <div class="flex items-center gap-2">
                                <span class="w-2 h-2 bg-slate-400 rounded-full"></span>
                                <span class="text-slate-400 font-semibold">Offline</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Page Views History --}}
    <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Riwayat Page Views</h3>

        @if ($pageViews->isEmpty())
            <div class="text-center py-12">
                <p class="text-slate-text">Tidak ada riwayat page views</p>
            </div>
        @else
            <div class="space-y-3">
                @foreach ($pageViews as $view)
                    @php
                        $segments = array_values(array_filter(explode('/', trim($view->page_url, '/'))));
                        $fallbackPageName = $segments ? ucfirst(str_replace('-', ' ', end($segments))) : 'Home';
                        $pageName = $view->page_title && $view->page_title !== $view->page_url ? $view->page_title : $fallbackPageName;
                    @endphp
                    <div class="flex items-start justify-between p-4 rounded-lg bg-navy/30 border border-navy-border hover:border-cyan/50 transition-colors">
                        <div class="flex-1 min-w-0">
                            <div class="text-white font-medium truncate">{{ $pageName }}</div>
                        </div>
                        <div class="text-right ml-4 shrink-0">
                            <div class="text-xs text-cyan font-semibold">WIB</div>
                            <div class="text-sm text-white font-medium">
                                {{ $view->viewed_at->timezone('Asia/Jakarta')->format('d M Y, H:i:s') }}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $pageViews->links() }}
            </div>
        @endif
    </div>

@endsection
