<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SpotController;


// Home route
Route::get('/', function () {
    return view('home');
})->name('home');

// Authentication routes
Route::middleware('guest')->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    // Registration routes
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard routes with role middleware
Route::middleware('auth')->group(function () {
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('spots', SpotController::class);
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/admin/users/{id}/toggle-block', [AdminController::class, 'toggleBlock'])->name('admin.users.toggle-block');
    });
    
    // Coach routes
    Route::middleware('role:coach')->group(function () {
        Route::get('/coach/dashboard', [CoachController::class, 'dashboard'])->name('coach.dashboard');
        Route::resource('spots', SpotController::class)->except(['destroy']);
        
    });
    
    // Player routes
    Route::middleware('role:player')->group(function () {
        Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    });
    
    // Calendar route - accessible to all authenticated users
Route::get('/calendar', function () {
    return view('calendar.index');
})->name('calendar');

// Calendar API routes
Route::middleware('auth')->group(function () {
    // Event routes
    Route::get('/api/events', [\App\Http\Controllers\EventController::class, 'index']);
    Route::post('/api/events', [\App\Http\Controllers\EventController::class, 'store']);
    Route::get('/api/events/{event}', [\App\Http\Controllers\EventController::class, 'show']);
    Route::put('/api/events/{event}', [\App\Http\Controllers\EventController::class, 'update']);
    Route::delete('/api/events/{event}', [\App\Http\Controllers\EventController::class, 'destroy']);
    
    // Category routes
    Route::get('/api/categories', [\App\Http\Controllers\CategoryController::class, 'index']);
    Route::post('/api/categories', [\App\Http\Controllers\CategoryController::class, 'store']);
    Route::get('/api/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'show']);
    Route::put('/api/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'update']);
    Route::delete('/api/categories/{category}', [\App\Http\Controllers\CategoryController::class, 'destroy']);
});
    
    // Generic dashboard route that redirects based on role
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif (auth()->user()->isCoach()) {
            return redirect()->route('coach.dashboard');
        } else {
            return redirect()->route('player.dashboard');
        }
    })->name('dashboard');
});
