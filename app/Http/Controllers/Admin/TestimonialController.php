<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->get();
        return view('dashboard.testimonials.index', compact('testimonials'));
    }

    public function approve($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_approved' => true]);
        return back()->with('success', 'Testimoni berhasil di-approve.');
    }

    public function reject($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['is_approved' => false]);
        return back()->with('success', 'Testimoni berhasil di-reject.');
    }

    public function destroy($id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->delete();
        return back()->with('success', 'Testimoni berhasil dihapus.');
    }
}
