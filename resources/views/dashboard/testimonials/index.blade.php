@extends('layouts.dashboard')
@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-white">Manajemen Testimoni</h1>
            <p class="text-slate-text text-sm mt-1">Approve atau reject feedback dari customer.</p>
        </div>
    </div>

    <div class="bg-navy-card border border-navy-border rounded-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-navy-border">
                        <th class="text-left text-slate-text font-medium px-6 py-4">Nama</th>
                        <th class="text-left text-slate-text font-medium px-6 py-4">Role</th>
                        <th class="text-left text-slate-text font-medium px-6 py-4">Konten</th>
                        <th class="text-left text-slate-text font-medium px-6 py-4">Status</th>
                        <th class="text-right text-slate-text font-medium px-6 py-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testimonials as $t)
                        <tr class="border-b border-navy-border/50 hover:bg-navy-border/20 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-gradient-to-br from-cyan to-cyan-dark flex items-center justify-center text-white text-xs font-bold">
                                        {{ substr($t->name, 0, 1) }}</div>
                                    <span class="text-white font-medium">{{ $t->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-slate-text">{{ $t->role_label }}</td>
                            <td class="px-6 py-4 text-slate-text max-w-xs truncate">{{ $t->content }}</td>
                            <td class="px-6 py-4">
                                <span
                                    class="inline-flex items-center gap-1.5 text-xs px-3 py-1 rounded-full font-medium {{ $t->is_approved ? 'bg-green-500/10 text-green-400' : 'bg-yellow-500/10 text-yellow-400' }}">
                                    <span
                                        class="w-1.5 h-1.5 rounded-full {{ $t->is_approved ? 'bg-green-400' : 'bg-yellow-400' }}"></span>
                                    {{ $t->is_approved ? 'Approved' : 'Pending' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    @if(!$t->is_approved)
                                        <form method="POST" action="{{ route('admin.testimonials.approve', $t->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium bg-green-500/10 text-green-400 rounded-lg hover:bg-green-500/20 transition-colors">Approve</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('admin.testimonials.reject', $t->id) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit"
                                                class="px-3 py-1.5 text-xs font-medium bg-yellow-500/10 text-yellow-400 rounded-lg hover:bg-yellow-500/20 transition-colors">Reject</button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.testimonials.destroy', $t->id) }}"
                                        onsubmit="return confirm('Hapus testimoni ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1.5 text-xs font-medium bg-red-500/10 text-red-400 rounded-lg hover:bg-red-500/20 transition-colors">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-text">Belum ada testimoni.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection