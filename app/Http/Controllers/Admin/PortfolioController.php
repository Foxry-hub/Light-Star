<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::latest()->get();
        return view('dashboard.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('dashboard.portfolios.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('portofolio', 'public');
        }

        Portfolio::create($validated);
        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('dashboard.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'video_url' => 'nullable|url',
        ]);

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it's in storage
            if ($portfolio->thumbnail && Storage::disk('public')->exists($portfolio->thumbnail)) {
                Storage::disk('public')->delete($portfolio->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('portofolio', 'public');
        } else {
            unset($validated['thumbnail']);
        }

        $portfolio->update($validated);
        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        if ($portfolio->thumbnail && Storage::disk('public')->exists($portfolio->thumbnail)) {
            Storage::disk('public')->delete($portfolio->thumbnail);
        }

        $portfolio->delete();
        return redirect()->route('admin.portfolios.index')->with('success', 'Portofolio berhasil dihapus.');
    }
}
