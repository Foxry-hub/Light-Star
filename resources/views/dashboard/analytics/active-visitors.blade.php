@extends('layouts.dashboard')

@section('content')
    <div class="mb-6 sm:mb-8">
        <a href="{{ route('admin.analytics.index') }}" class="text-cyan hover:text-cyan-light mb-4 inline-flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali ke Analytics
        </a>
        <h1 class="text-2xl font-bold text-white">Pengunjung Aktif</h1>
        <p class="text-slate-text text-sm mt-1">Daftar pengunjung yang sedang aktif di website (15 menit terakhir)</p>
    </div>

    {{-- Active Count Badge --}}
    <div class="mb-6 sm:mb-8">
        <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-text text-sm">Total Pengunjung Aktif</p>
                    <p class="text-4xl font-bold text-cyan mt-2" id="active-count">{{ $activeVisitors->total() }}</p>
                </div>
                <div class="text-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-green-500/10 rounded-lg">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span class="text-green-400 text-sm font-semibold">Live</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Visitors List --}}
    <div class="bg-navy-card border border-navy-border rounded-2xl p-6">
        <h3 class="text-lg font-semibold text-white mb-6">Daftar Pengunjung</h3>
        
        @if ($activeVisitors->isEmpty())
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-slate-text/30 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 00-6-6 6 6 0 00-6 6z"></path>
                </svg>
                <p class="text-slate-text">Tidak ada pengunjung aktif saat ini</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-navy-border">
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text">Nama/Info</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text hidden sm:table-cell">IP Address</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text">Device</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text hidden md:table-cell">Browser</th>
                            <th class="text-left px-4 py-3 text-sm font-semibold text-slate-text">Aktivitas</th>
                            <th class="text-right px-4 py-3 text-sm font-semibold text-slate-text">Pages</th>
                            <th class="text-right px-4 py-3 text-sm font-semibold text-slate-text"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($activeVisitors as $visitor)
                            <tr class="border-b border-navy-border hover:bg-navy/30 transition-colors">
                                <td class="px-4 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse shrink-0"></div>
                                        <div>
                                            <div class="text-white font-medium">
                                                {{ $visitor->user?->name ?? 'Pengunjung Anonymous' }}
                                            </div>
                                            @if ($visitor->country || $visitor->city)
                                                <div class="text-xs text-slate-text">
                                                    {{ $visitor->city }}{{ $visitor->country ? ', ' . $visitor->country : '' }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-4 hidden sm:table-cell">
                                    <span class="text-sm text-slate-text font-mono">{{ $visitor->visitor_ip }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <span class="inline-flex items-center gap-1 px-2 py-1 bg-blue-500/10 text-blue-400 rounded text-xs font-medium capitalize">
                                        @if ($visitor->device_type === 'mobile')
                                            📱
                                        @elseif ($visitor->device_type === 'tablet')
                                            📱
                                        @else
                                            🖥️
                                        @endif
                                        {{ $visitor->device_type }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 hidden md:table-cell">
                                    <span class="text-sm text-white">{{ $visitor->browser ?? '-' }}</span>
                                </td>
                                <td class="px-4 py-4">
                                    <div class="text-sm text-slate-text">
                                        <span class="text-white font-semibold">{{ $visitor->last_activity_at->diffForHumans() }}</span>
                                    </div>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <span class="inline-flex items-center justify-center px-3 py-1 bg-cyan/10 text-cyan rounded-lg text-sm font-semibold">
                                        {{ $visitor->page_views_count }}
                                    </span>
                                </td>
                                <td class="px-4 py-4 text-right">
                                    <a href="{{ route('admin.analytics.visitor-detail', $visitor->session_id) }}"
                                        class="text-cyan hover:text-cyan-light text-sm font-medium transition-colors">
                                        Detail →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $activeVisitors->links() }}
            </div>
        @endif
    </div>

@endsection

@push('scripts')
    <script>
        // Auto-refresh active visitors count every 10 seconds
        setInterval(function() {
            fetch('{{ route('admin.analytics.api-stats') }}')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('active-count').textContent = data.active_visitors;
                });
        }, 10000);
    </script>
@endpush
