<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JournalController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TutoringController;
use Illuminate\Support\Facades\Route;

// Public
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::prefix('blog')->name('posts.')->group(function () {
    Route::get('/', [PostController::class, 'index'])->name('index');
    Route::get('/{post:slug}', [PostController::class, 'show'])->name('show');
});

Route::get('/faq', [FaqController::class, 'index'])->name('faq');

Route::get('/tutoring', [TutoringController::class, 'index'])->name('tutoring.index');
Route::post('/tutoring', [TutoringController::class, 'store'])->name('tutoring.store');

// Forum: browsing is public, posting requires auth
Route::prefix('forum')->name('forum.')->group(function () {
    Route::get('/', [ForumController::class, 'index'])->name('index');
    Route::get('/{thread:slug}', [ForumController::class, 'show'])->name('show');

    Route::middleware('auth')->group(function () {
        Route::get('/create/new', [ForumController::class, 'create'])->name('create');
        Route::post('/', [ForumController::class, 'store'])->name('store');
        Route::post('/{thread:slug}/reply', [ForumController::class, 'reply'])->name('reply');
    });
});

// Guest-only auth routes
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// Authenticated-only features
Route::middleware('auth')->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/chat/rooms/{room}/messages', [ChatController::class, 'store'])->name('chat.store');

    Route::prefix('journal')->name('journal.')->group(function () {
        Route::get('/', [JournalController::class, 'index'])->name('index');
        Route::get('/create', [JournalController::class, 'create'])->name('create');
        Route::post('/', [JournalController::class, 'store'])->name('store');
        Route::get('/{trade}/edit', [JournalController::class, 'edit'])->name('edit');
        Route::put('/{trade}', [JournalController::class, 'update'])->name('update');
        Route::delete('/{trade}', [JournalController::class, 'destroy'])->name('destroy');
    });
});

// Admin-only area
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [AdminPostController::class, 'index'])->name('index');
        Route::get('/create', [AdminPostController::class, 'create'])->name('create');
        Route::post('/', [AdminPostController::class, 'store'])->name('store');
    });

    Route::prefix('leads')->name('leads.')->group(function () {
        Route::get('/', [AdminLeadController::class, 'index'])->name('index');
        Route::put('/{lead}', [AdminLeadController::class, 'update'])->name('update');
    });
});
