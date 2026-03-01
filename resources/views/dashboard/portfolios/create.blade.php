@extends('layouts.dashboard')
@section('content')
    <div class="mb-8">
        <a href="{{ route('admin.portfolios.index') }}" class="text-cyan text-sm hover:text-cyan-light transition-colors">←
            Kembali ke Daftar</a>
        <h1 class="text-2xl font-bold text-white mt-4">Tambah Portofolio</h1>
    </div>

    <div class="max-w-2xl">
        <form method="POST" action="{{ route('admin.portfolios.store') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            <div>
                <label for="title" class="block text-sm font-medium text-white mb-2">Judul Acara</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                    class="newsletter-input w-full" placeholder="Contoh: Webinar Nasional Pendidikan">
                @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="description" class="block text-sm font-medium text-white mb-2">Deskripsi</label>
                <textarea name="description" id="description" rows="4" class="newsletter-input w-full resize-none"
                    placeholder="Deskripsi singkat acara...">{{ old('description') }}</textarea>
                @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="thumbnail" class="block text-sm font-medium text-white mb-2">Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" required accept="image/*"
                    class="w-full text-sm text-slate-text file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-cyan/10 file:text-cyan hover:file:bg-cyan/20 file:cursor-pointer">
                @error('thumbnail') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="video_url" class="block text-sm font-medium text-white mb-2">Link Video (YouTube)</label>
                <input type="url" name="video_url" id="video_url" value="{{ old('video_url') }}"
                    class="newsletter-input w-full" placeholder="https://www.youtube.com/watch?v=...">
                @error('video_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-cyan"><span>Simpan Portofolio</span></button>
                <a href="{{ route('admin.portfolios.index') }}"
                    class="px-6 py-3 text-sm font-medium border border-navy-border text-slate-text rounded-xl hover:border-cyan hover:text-cyan transition-all">Batal</a>
            </div>
        </form>
    </div>
@endsection