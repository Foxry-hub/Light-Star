<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_portfolios' => Portfolio::count(),
            'total_testimonials' => Testimonial::count(),
            'approved_testimonials' => Testimonial::where('is_approved', true)->count(),
            'pending_testimonials' => Testimonial::where('is_approved', false)->count(),
        ];

        $recentPortfolios = Portfolio::latest()->take(5)->get();
        $recentTestimonials = Testimonial::latest()->take(5)->get();

        return view('dashboard.index', compact('stats', 'recentPortfolios', 'recentTestimonials'));
    }
}
