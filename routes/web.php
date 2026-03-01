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

// Landing Page (public)
Route::get('/', function () {
    $portfolios = Portfolio::latest()->get();
    $testimonials = Testimonial::approved()->get();
    return view('welcome', compact('portfolios', 'testimonials'));
})->name('home');

// Public testimonial submission
Route::post('/testimonial', [TestimonialSubmissionController::class, 'store'])->name('testimonial.store');

// Google OAuth routes
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// Admin Dashboard routes
Route::middleware(['auth', 'admin'])->prefix('dashboard')->name('admin.')->group(function () {
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
