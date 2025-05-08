<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;


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
    });
    
    // Coach routes
    Route::middleware('role:coach')->group(function () {
        Route::get('/coach/dashboard', [CoachController::class, 'dashboard'])->name('coach.dashboard');
    });
    
    // Player routes
    Route::middleware('role:player')->group(function () {
        Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    });
});
