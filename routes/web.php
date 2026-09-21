<?php

use App\Http\Controllers\BrowseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
Route::get('/map', [PageController::class, 'map'])->name('map');
Route::get('/agents', [PageController::class, 'agents'])->name('agents');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/privacy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/cookies', [PageController::class, 'cookies'])->name('cookies');
Route::post('/newsletter', [NewsletterController::class, 'store'])->name('newsletter.store');
Route::get('/listings/{slug}', [ListingController::class, 'show'])->name('listings.show');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [\App\Http\Controllers\Admin\AuthController::class, 'create'])->name('login');
    Route::post('/login', [\App\Http\Controllers\Admin\AuthController::class, 'store'])->name('login.store');
    Route::post('/logout', [\App\Http\Controllers\Admin\AuthController::class, 'destroy'])->name('logout');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [PropertyController::class, 'dashboard'])->name('dashboard');

    Route::get('/properties/create', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/properties', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])->name('properties.edit');
    Route::put('/properties/{property}', [PropertyController::class, 'update'])->name('properties.update');
    Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])->name('properties.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

        Route::get('/properties', [\App\Http\Controllers\Admin\PropertyController::class, 'index'])->name('properties.index');
        Route::get('/properties/{property}/edit', [\App\Http\Controllers\Admin\PropertyController::class, 'edit'])->name('properties.edit');
        Route::put('/properties/{property}', [\App\Http\Controllers\Admin\PropertyController::class, 'update'])->name('properties.update');
        Route::post('/properties/{property}/publish', [\App\Http\Controllers\Admin\PropertyController::class, 'publish'])->name('properties.publish');
        Route::post('/properties/{property}/reject', [\App\Http\Controllers\Admin\PropertyController::class, 'reject'])->name('properties.reject');

        Route::get('/hero-slides', [\App\Http\Controllers\Admin\HeroSlideController::class, 'index'])->name('hero-slides.index');
        Route::get('/hero-slides/create', [\App\Http\Controllers\Admin\HeroSlideController::class, 'create'])->name('hero-slides.create');
        Route::post('/hero-slides', [\App\Http\Controllers\Admin\HeroSlideController::class, 'store'])->name('hero-slides.store');
        Route::post('/hero-slides/{heroSlide}/toggle', [\App\Http\Controllers\Admin\HeroSlideController::class, 'toggle'])->name('hero-slides.toggle');
        Route::delete('/hero-slides/{heroSlide}', [\App\Http\Controllers\Admin\HeroSlideController::class, 'destroy'])->name('hero-slides.destroy');

        Route::get('/agents', [\App\Http\Controllers\Admin\AgentController::class, 'index'])->name('agents.index');
        Route::post('/agents/{user}/toggle-verified', [\App\Http\Controllers\Admin\AgentController::class, 'toggleVerified'])->name('agents.toggle-verified');
    });
});

require __DIR__.'/auth.php';
