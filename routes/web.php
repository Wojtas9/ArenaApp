<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SpotController;

use App\Http\Controllers\MessageController;
use App\Http\Controllers\DashboardController;



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

    Route::middleware(['auth', 'check.role:coach'])->group(function () {
        Route::get('/coach/dashboard', [DashboardController::class, 'coachDashboard'])->name('coach.dashboard');
    });
    
    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('spots', SpotController::class);

        // User management routes

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
       Route::delete('spots/{spot}', [SpotController::class, 'destroy'])->name('spots.destroy');

    });
    
    // Player routes
    Route::middleware('role:player')->group(function () {
        Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
    });

    
    // Message routes (available to all authenticated users)
    Route::resource('messages', MessageController::class)->except(['edit', 'update']);
    Route::get('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

});
