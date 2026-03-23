<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TestimonialSubmissionController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\PortfolioController;
use App\Models\Portfolio;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$demoPortfolioTitles = [
    'Webinar Nasional Pendidikan',
    'Live Wedding Bali',
    'Corporate Annual Meeting',
    'Live Concert Jakarta',
];

$demoTestimonialContents = [
    'Light Star benar-benar menyelamatkan acara kami! Setup streaming yang cepat dan kualitas video yang luar biasa. Tim mereka sangat profesional dan responsif.',
    'Klien kami sangat puas dengan hasil live streaming pernikahan. Keluarga yang tidak bisa hadir merasa seolah ada di lokasi. Terima kasih Light Star!',
    'Sudah 3 kali menggunakan jasa Light Star untuk event perusahaan kami. Selalu konsisten dengan kualitas terbaik. Highly recommended!',
    'Pertama kali menggunakan jasa live streaming dan hasilnya diluar ekspektasi. Tim Light Star sangat kooperatif.',
];

// Landing Page (public)
Route::get('/', function () use ($demoPortfolioTitles, $demoTestimonialContents) {
    $showDemoData = (bool) config('app.enable_demo_data');

    $portfolios = Portfolio::query()
        ->when(!$showDemoData, function ($query) use ($demoPortfolioTitles) {
            $query->whereNotIn('title', $demoPortfolioTitles);
        })
        ->latest()
        ->take(8)
        ->get();

    $testimonials = Testimonial::approved()
        ->when(!$showDemoData, function ($query) use ($demoTestimonialContents) {
            $query->whereNotIn('content', $demoTestimonialContents);
        })
        ->with('user')
        ->get();

    return view('welcome', compact('portfolios', 'testimonials'));
})->name('home');

// Public testimonial submission
Route::post('/testimonial', [TestimonialSubmissionController::class, 'store'])->name('testimonial.store');

// Helper redirect so guests can login and return to testimonial section
Route::get('/testimonial/signin', function (Request $request) {
    $request->session()->put('url.intended', route('home') . '#bagikan-pengalaman');
    return redirect()->route('login');
})->middleware('guest')->name('testimonial.signin');

// Full Portfolio page (public)
Route::get('/portfolio', function () use ($demoPortfolioTitles) {
    $showDemoData = (bool) config('app.enable_demo_data');

    $portfolios = Portfolio::query()
        ->when(!$showDemoData, function ($query) use ($demoPortfolioTitles) {
            $query->whereNotIn('title', $demoPortfolioTitles);
        })
        ->latest()
        ->paginate(12);

    return view('portfolio', compact('portfolios'));
})->name('portfolio.index');

// Google OAuth routes
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])
    ->middleware('throttle:20,1')
    ->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])
    ->middleware('throttle:20,1')
    ->name('google.callback');

// Admin Dashboard routes
Route::middleware(['auth', 'verified', 'admin'])->prefix('dashboard')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Testimonials Management
    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('testimonials.index');
    Route::patch('/testimonials/{id}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::patch('/testimonials/{id}/reject', [TestimonialController::class, 'reject'])->name('testimonials.reject');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('testimonials.destroy');

    // Portfolio CRUD
    Route::get('/portfolios', [PortfolioController::class, 'index'])->name('portfolios.index');
    Route::get('/portfolios/create', [PortfolioController::class, 'create'])->name('portfolios.create');
    Route::post('/portfolios', [PortfolioController::class, 'store'])->name('portfolios.store');
    Route::get('/portfolios/{portfolio}/edit', [PortfolioController::class, 'edit'])->name('portfolios.edit');
    Route::put('/portfolios/{portfolio}', [PortfolioController::class, 'update'])->name('portfolios.update');
    Route::delete('/portfolios/{portfolio}', [PortfolioController::class, 'destroy'])->name('portfolios.destroy');
});

// Profile routes (authenticated users)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
