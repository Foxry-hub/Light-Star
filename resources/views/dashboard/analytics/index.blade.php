@extends('layouts.dashboard')

@section('content')
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl font-bold text-white">Analytics & Visitor Tracking</h1>
        <p class="text-slate-text text-sm mt-1">Monitor traffic, visitors, dan statistik website secara real-time</p>
    </div>

    {{-- Date Range Filter --}}
    <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 mb-6 sm:mb-8">
        <form method="GET" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <label class="text-sm text-slate-text mb-2 block">Tanggal Mulai</label>
                <input type="date" name="start_date" value="{{ $startDate->format('Y-m-d') }}"
                    class="w-full bg-navy-input border border-navy-border rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-cyan focus:border-transparent">
            </div>
            <div class="flex-1">
                <label class="text-sm text-slate-text mb-2 block">Tanggal Akhir</label>
                <input type="date" name="end_date" value="{{ $endDate->format('Y-m-d') }}"
                    class="w-full bg-navy-input border border-navy-border rounded-lg px-4 py-2 text-white focus:ring-2 focus:ring-cyan focus:border-transparent">
            </div>
            <div class="flex items-end gap-3">
                <button type="submit"
                    class="px-4 py-2 bg-cyan text-navy font-semibold rounded-lg hover:bg-cyan-light transition-colors">
                    Filter
                </button>
                <a href="{{ route('admin.analytics.index') }}"
                    class="px-4 py-2 bg-navy-input border border-navy-border text-white rounded-lg hover:bg-navy-border/50 transition-colors">
                    Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Overall Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-6 sm:mb-8">
        {{-- Total Page Views --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3.042.525A9.006 9.006 0 002.25 9m14.25-9h.008v.008h-.008V6.042zM12 18a8.967 8.967 0 006-2.292m0 0A9.006 9.006 0 0021.75 9M12 18a8.967 8.967 0 00-6 2.292m0 0A9.006 9.006 0 002.25 9" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ number_format($stats['total_page_views']) }}</div>
            <div class="text-sm text-slate-text mt-1">Total Page Views</div>
        </div>

        {{-- Unique Visitors --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-green-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 001.591-.079 8.975 8.975 0 005.993-5.993 9.328 9.328 0 00.079-1.591A9.375 9.375 0 0015 6.375m0 12.75A9.375 9.375 0 007.5 6.375m0 0a9 9 0 1118 0m-18 12.75h18.75" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ number_format($stats['unique_visitors']) }}</div>
            <div class="text-sm text-slate-text mt-1">Unique Visitors</div>
        </div>

        {{-- Active Visitors Now --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z" fill="currentColor" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['active_visitors'] }}</div>
            <div class="text-sm text-slate-text mt-1">Pengunjung Aktif Sekarang</div>
        </div>

        {{-- New Visitors Today --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-4 sm:p-6 min-w-0">
            <div class="flex items-center justify-between mb-4">
                <div class="w-10 h-10 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path d="M18 7.5v11.25m0 0l-3-3m3 3l3-3M3.375 7.5V21M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5.25-3a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>
                </div>
            </div>
            <div class="text-2xl font-bold text-white">{{ $stats['new_visitors_today'] }}</div>
            <div class="text-sm text-slate-text mt-1">Pengunjung Baru Hari Ini</div>
        </div>
    </div>

    {{-- Range Statistics --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Statistik Periode</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center pb-4 border-b border-navy-border">
                    <span class="text-slate-text">Page Views</span>
                    <span class="text-2xl font-bold text-cyan">{{ number_format($rangeStats['page_views']) }}</span>
                </div>
                <div class="flex justify-between items-center pb-4 border-b border-navy-border">
                    <span class="text-slate-text">Unique Visitors</span>
                    <span class="text-2xl font-bold text-green-400">{{ number_format($rangeStats['unique_visitors']) }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-slate-text">Periode</span>
                    <span class="text-sm text-white">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Pengunjung Aktif</h3>
            <div class="space-y-3">
                @if ($activeVisitors->isEmpty())
                    <p class="text-slate-text text-sm">Tidak ada pengunjung aktif saat ini</p>
                @else
                    @foreach ($activeVisitors->take(5) as $visitor)
                        <div class="flex items-center justify-between p-3 rounded-lg bg-navy/30">
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-medium text-white">
                                    {{ $visitor->user?->name ?? 'Anonymous' }}
                                </div>
                                <div class="text-xs text-slate-text">
                                    {{ $visitor->visitor_ip }} • {{ $visitor->device_type }}
                                </div>
                            </div>
                            <span class="px-2 py-1 text-xs font-semibold bg-green-500/20 text-green-400 rounded">
                                Aktif
                            </span>
                        </div>
                    @endforeach
                    @if ($activeVisitors->count() > 5)
                        <a href="{{ route('admin.analytics.active-visitors') }}"
                            class="text-cyan text-sm hover:text-cyan-light transition-colors block mt-3">
                            Lihat Semua →
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>

    {{-- Charts Row --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        {{-- Page Views Trend --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Trend Page Views (7 Hari)</h3>
            <div class="space-y-3">
                @php
                    $maxViews = $pageViewsTrend->max('views') ?? 1;
                @endphp
                @foreach ($pageViewsTrend as $item)
                    <div class="flex items-end gap-3">
                        <div class="w-24 text-xs text-slate-text">
                            {{ Carbon\Carbon::parse($item->date)->format('d M') }}
                        </div>
                        <div class="flex-1 bg-navy-input rounded-lg overflow-hidden h-8" style="position: relative;">
                            <div class="bg-cyan h-full transition-all duration-300"
                                style="width: {{ ($item->views / $maxViews) * 100 }}%"></div>
                        </div>
                        <div class="w-12 text-right text-sm font-medium text-white">
                            {{ number_format($item->views) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Unique Visitors Trend --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Trend Unique Visitors (7 Hari)</h3>
            <div class="space-y-3">
                @php
                    $maxVisitors = $uniqueVisitorsTrend->max('visitors') ?? 1;
                @endphp
                @foreach ($uniqueVisitorsTrend as $item)
                    <div class="flex items-end gap-3">
                        <div class="w-24 text-xs text-slate-text">
                            {{ Carbon\Carbon::parse($item->date)->format('d M') }}
                        </div>
                        <div class="flex-1 bg-navy-input rounded-lg overflow-hidden h-8" style="position: relative;">
                            <div class="bg-green-400 h-full transition-all duration-300"
                                style="width: {{ ($item->visitors / $maxVisitors) * 100 }}%"></div>
                        </div>
                        <div class="w-12 text-right text-sm font-medium text-white">
                            {{ number_format($item->visitors) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Device & Browser Stats --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6 mb-6 sm:mb-8">
        {{-- Device Types --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Pengunjung Berdasarkan Device</h3>
            <div class="space-y-3">
                @php
                    $totalDevices = $visitorsByDevice->sum();
                    $deviceIcons = [
                        'mobile' => '📱',
                        'tablet' => '📱',
                        'desktop' => '🖥️',
                    ];
                @endphp
                @forelse ($visitorsByDevice as $device => $count)
                    <div class="flex items-center gap-3">
                        <span class="text-lg">{{ $deviceIcons[$device] ?? '🔧' }}</span>
                        <div class="flex-1">
                            <div class="flex justify-between mb-1">
                                <span class="text-sm text-white capitalize">{{ $device }}</span>
                                <span class="text-sm font-semibold text-white">{{ number_format($count) }}</span>
                            </div>
                            <div class="w-full bg-navy-input rounded-full h-2">
                                <div class="bg-blue-400 h-2 rounded-full"
                                    style="width: {{ ($count / $totalDevices) * 100 }}%"></div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-text text-sm">Tidak ada data device</p>
                @endforelse
            </div>
        </div>

        {{-- Top Browsers --}}
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <h3 class="text-lg font-semibold text-white mb-4">Browser Teratas</h3>
            <div class="space-y-3">
                @php
                    $totalBrowsers = $visitorsByBrowser->sum();
                @endphp
                @forelse ($visitorsByBrowser as $browser => $count)
                    <div class="flex items-center justify-between p-3 rounded-lg bg-navy/30">
                        <span class="text-white font-medium">{{ $browser }}</span>
                        <div class="flex items-center gap-2">
                            <div class="text-right">
                                <div class="text-sm font-semibold text-cyan">{{ number_format($count) }}</div>
                                <div class="text-xs text-slate-text">
                                    {{ round(($count / $totalBrowsers) * 100) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-slate-text text-sm">Tidak ada data browser</p>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Top Pages --}}
    <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold text-white">Halaman Paling Sering Dibuka</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-navy-border">
                        <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text">Halaman</th>
                        <th class="text-right px-4 py-3 text-sm font-semibold text-slate-text">Total Views</th>
                        <th class="text-right px-4 py-3 text-sm font-semibold text-slate-text">Unique Views</th>
                        <th class="text-right px-4 py-3 text-sm font-semibold text-slate-text">%</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $totalPageViews = $topPages->sum('views');
                    @endphp
                    @forelse ($topPages as $page)
                        <tr class="border-b border-navy-border hover:bg-navy/30 transition-colors">
                            <td class="px-4 py-4">
                                <div class="text-white font-medium truncate">{{ $page->page_name }}</div>
                            </td>
                            <td class="px-4 py-4 text-right text-white font-semibold">{{ number_format($page->views) }}</td>
                            <td class="px-4 py-4 text-right text-white font-semibold">{{ number_format($page->unique_views) }}</td>
                            <td class="px-4 py-4 text-right">
                                <span class="text-cyan font-semibold">{{ round(($page->views / $totalPageViews) * 100) }}%</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-text">
                                Tidak ada data halaman
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        // Optional: Auto-refresh analytics every 30 seconds
        setInterval(function() {
            // You can add auto-refresh logic here if needed
        }, 30000);
    </script>
@endpush
