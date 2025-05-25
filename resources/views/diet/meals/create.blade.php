@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>

    <div class="flex h-270 max-w-[1400px] mx-auto gap-5 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '🍽️',
            'sidebarTitle' => $mealPlan->name ?? 'Add Meal',
            'sidebarSubtitle' => 'To Meal Plan',
            'navLinks' => [] // Dynamic links can be added here if needed
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
            <h1 class="text-2xl font-bold mb-6">Add Meal to {{ $mealPlan->name ?? 'Meal Plan' }}</h1>

            <form action="{{ route('meal-plans.meals.store', $mealPlan->id ?? '') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="day" class="block text-gray-700 text-sm font-bold mb-2">Day:</label>
                    <input type="date" name="day" id="day" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                </div>

                <div class="mb-4">
                    <label for="type" class="block text-gray-700 text-sm font-bold mb-2">Meal Type:</label>
                    <select name="type" id="type" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        <option value="breakfast">Breakfast</option>
                        <option value="lunch">Lunch</option>
                        <option value="dinner">Dinner</option>
                        <option value="snack">Snack</option>
                    </select>
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Add Meal
                    </button>
                    <a href="{{ route('meal-plans.show', $mealPlan->id ?? '') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection