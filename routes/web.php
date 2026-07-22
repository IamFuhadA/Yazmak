<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Frontend
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/projects', [FrontendController::class, 'projects'])->name('projects');
Route::get('/contact', [FrontendController::class, 'contact'])
    ->name('contact');
Route::post('/contact', [ContactController::class, 'store'])
    ->name('contact.store');
Route::redirect('/dashboard', '/admin/dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin
Route::middleware(['auth', 'verified'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::view('/dashboard', 'admin.dashboard')
            ->name('dashboard');

        Route::resource('projects', ProjectController::class);
        Route::resource('about', AboutController::class);
        Route::resource('skills', SkillController::class);

    });

// Profile
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

require __DIR__.'/auth.php';
