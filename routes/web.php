<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\TrainingProgramsController;
use App\Http\Controllers\CoachProfileController;

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
    // Coach dashboard route
    Route::middleware('role:coach')->group(function () {
        Route::get('/coach/dashboard', [CoachController::class, 'dashboard'])->name('coach.dashboard');
    });

    // Shared routes for admin and coach
    Route::middleware('role:admin|coach')->group(function () {
        Route::resource('spots', SpotController::class);
    });

    // Admin routes
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // User management routes
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/admin/users/{id}/edit', [AdminController::class, 'edit'])->name('admin.users.edit');
        Route::put('/admin/users/{id}', [AdminController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy');
        Route::post('/admin/users/{id}/toggle-block', [AdminController::class, 'toggleBlock'])->name('admin.users.toggle-block');
    });

    // Player routes
    Route::middleware('role:player')->group(function () {
        Route::get('/player/dashboard', [PlayerController::class, 'dashboard'])->name('player.dashboard');
        Route::resource('messages', MessageController::class)->except(['update']);
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

        // Spot routes
        Route::get('/api/spots', [\App\Http\Controllers\SpotController::class, 'apiIndex']);

        // Instructor routes
        Route::get('/api/instructors', [\App\Http\Controllers\AdminController::class, 'getCoaches']);
    });

    // Message routes (available to all authenticated users)
    Route::resource('messages', MessageController::class)->except(['edit', 'update']);
    Route::get('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

    Route::resource('training-programs', TrainingProgramsController::class);
    Route::post('training-programs/{trainingProgram}/add-training', [TrainingProgramsController::class, 'addTraining'])->name('training-programs.add-training');
    Route::delete('training-programs/{trainingProgram}/remove-training', [TrainingProgramsController::class, 'removeTraining'])->name('training-programs.remove-training');

    // Coach Profile Routes
    Route::get('/coach-profiles', [CoachProfileController::class, 'index'])->name('coach-profiles.index');
    Route::get('/coach-profiles/create', [CoachProfileController::class, 'create'])->name('coach-profiles.create');
    Route::post('/coach-profiles', [CoachProfileController::class, 'store'])->name('coach-profiles.store');
    Route::get('/coach-profiles/{id}', [CoachProfileController::class, 'show'])->name('coach-profiles.show');
    Route::get('/coach-profiles/{id}/edit', [CoachProfileController::class, 'edit'])->name('coach-profiles.edit');
    Route::post('/coach-profiles/{id}', [CoachProfileController::class, 'update'])->name('coach-profiles.update');
    Route::delete('/coach-profiles/{id}', [CoachProfileController::class, 'destroy'])->name('coach-profiles.destroy');
    Route::get('/coach-profiles-search', [CoachProfileController::class, 'search'])->name('coach-profiles.search');

    Route::get('/coach/profile/{profile}/edit', [CoachProfileController::class, 'edit'])
        ->name('coach.profile.edit');
});

// Training Notes Routes
Route::resource('training-notes', 'App\Http\Controllers\TrainingNoteController');
