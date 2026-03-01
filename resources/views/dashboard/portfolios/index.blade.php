@extends('layouts.dashboard')
@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Portofolio</h1>
            <p class="text-slate-text text-sm mt-1">Kelola portofolio acara Light Star.</p>
        </div>
        <a href="{{ route('admin.portfolios.create') }}" class="btn-cyan text-sm"><span>+ Tambah Portofolio</span></a>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($portfolios as $p)
            <div class="bg-navy-card border border-navy-border rounded-2xl overflow-hidden group">
                <div class="relative h-48 overflow-hidden">
                    <img src="{{ str_starts_with($p->thumbnail, 'assets/') ? asset($p->thumbnail) : asset('storage/' . $p->thumbnail) }}"
                        alt="{{ $p->title }}"
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                </div>
                <div class="p-5">
                    <h3 class="text-white font-semibold mb-2">{{ $p->title }}</h3>
                    <p class="text-slate-text text-sm mb-4 line-clamp-2">{{ $p->description }}</p>
                    @if($p->video_url)
                        <a href="{{ $p->video_url }}" target="_blank"
                            class="text-cyan text-xs hover:text-cyan-light transition-colors mb-4 inline-block">🔗 Link Video</a>
                    @endif
                    <div class="flex items-center gap-2 pt-4 border-t border-navy-border">
                        <a href="{{ route('admin.portfolios.edit', $p) }}"
                            class="flex-1 text-center px-3 py-2 text-xs font-medium bg-cyan/10 text-cyan rounded-lg hover:bg-cyan/20 transition-colors">Edit</a>
                        <form method="POST" action="{{ route('admin.portfolios.destroy', $p) }}"
                            onsubmit="return confirm('Hapus portofolio ini?')" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit"
                                class="w-full px-3 py-2 text-xs font-medium bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-colors">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-slate-text mb-4">Belum ada portofolio.</p>
                <a href="{{ route('admin.portfolios.create') }}" class="btn-cyan text-sm"><span>Tambah Portofolio
                        Pertama</span></a>
            </div>
        @endforelse
    </div>
@endsection