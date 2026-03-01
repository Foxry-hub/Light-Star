<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialSubmissionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'role_label' => 'required|string|max:100',
            'content' => 'required|string|min:10|max:500',
        ]);

        Testimonial::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name' => $request->name,
            'role_label' => $request->role_label,
            'content' => $request->content,
            'is_approved' => false,
        ]);

        return redirect()->back()->with('testimonial_success', 'Terima kasih! Testimoni Anda telah dikirim dan sedang menunggu persetujuan admin.');
    }
}
