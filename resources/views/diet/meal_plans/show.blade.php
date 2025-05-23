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
            'sidebarTitle' => $mealPlan->name ?? 'Meal Plan Details',
            'sidebarSubtitle' => 'View Details',
            'navLinks' => [] // Dynamic links can be added here if needed
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
            <h1 class="text-2xl font-bold mb-6">{{ $mealPlan->name ?? 'Meal Plan Details' }}</h1>

            <div class="mb-4">
                <p class="text-gray-700 text-sm font-bold mb-2">Description:</p>
                <p>{{ $mealPlan->description ?? 'No description provided.' }}</p>
            </div>

            {{-- Placeholder for meals within the meal plan --}}
            <div id="meals-list">
                <h2 class="text-xl font-semibold mb-4">Meals</h2>
                {{-- Meals for this meal plan will be loaded here --}}
                <p>Loading meals...</p>
            </div>

            {{-- Placeholder for Edit and Delete buttons --}}
            <div class="mt-6 flex gap-4">
                <a href="{{ route('meal-plans.edit', $mealPlan->id ?? '') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Edit Meal Plan
                </a>
                <form action="{{ route('meal-plans.destroy', $mealPlan->id ?? '') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this meal plan?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete Meal Plan
                    </button>
                </form>
                <a href="{{ route('meal-plans.index') }}" class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">
                    Back to Meal Plans
                </a>
            </div>
        </div>
    </div>
</div>
@endsection