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

    // Diet and Nutritional Goals routes
    Route::prefix('diet')->name('diet.')->group(function () {
        Route::get('/', [App\Http\Controllers\DietController::class, 'index'])->name('index');

        // Nutritional Goals routes
        Route::prefix('nutritional-goals')->name('nutritional-goals.')->group(function () {
            Route::get('/create', [App\Http\Controllers\DietController::class, 'createNutritionalGoal'])->name('create');
            Route::get('/', [App\Http\Controllers\DietController::class, 'indexNutritionalGoals'])->name('index');
            Route::post('/', [App\Http\Controllers\DietController::class, 'storeNutritionalGoal'])->name('store');
            Route::get('/{nutritionalGoal}/edit', [App\Http\Controllers\DietController::class, 'editNutritionalGoal'])->name('edit');
            Route::put('/{nutritionalGoal}', [App\Http\Controllers\DietController::class, 'updateNutritionalGoal'])->name('update');
            Route::delete('/{nutritionalGoal}', [App\Http\Controllers\DietController::class, 'deleteNutritionalGoal'])->name('delete');
        });

        // Diet Plans routes
        Route::prefix('diet-plans')->name('diet-plans.')->group(function () {
            Route::get('/create', [App\Http\Controllers\DietController::class, 'createDietPlan'])->name('create');
            Route::get('/', [App\Http\Controllers\DietController::class, 'indexDietPlans'])->name('index');
            Route::post('/', [App\Http\Controllers\DietController::class, 'storeDietPlan'])->name('store');
            Route::get('/{dietPlan}/edit', [App\Http\Controllers\DietController::class, 'editDietPlan'])->name('edit');
            Route::put('/{dietPlan}', [App\Http\Controllers\DietController::class, 'updateDietPlan'])->name('update');
            Route::delete('/{dietPlan}', [App\Http\Controllers\DietController::class, 'deleteDietPlan'])->name('delete');
        });
    });
});

    // Diet and Meal Plan Routes (Accessible by coach and potentially player)
    Route::middleware('role:coach|player')->group(function () {
        Route::resource('meal-plans', \App\Http\Controllers\Diet\MealPlanController::class);
        Route::resource('meal-plans.meals', \App\Http\Controllers\Diet\MealController::class)->shallow();
        Route::resource('meals.food-items', \App\Http\Controllers\Diet\FoodItemController::class)->shallow();
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
