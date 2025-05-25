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
            'sidebarIcon' => '🍎', // Placeholder icon for Diet
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '🍎', 'text' => 'My Diet', 'href' => route('diet.index'), 'active_check_route_name' => 'diet.index'],
                ['icon' => '⚙️', 'text' => 'Settings', 'href' => '#', 'active_check_route_name' => 'settings'] // Placeholder link
            ]
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg drop-shadow-xl/50 flex flex-col h-full">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900">My Meal Plans</h1>
                <div class="mt-4 flex justify-between items-center">
                <button id="openDietPlanModal" class="float-left bg-[#cf5b44] text-white px-4 py-2 rounded-lg shadow hover:bg-[#b54a36] transition duration-200 ">Add Meal Plan</button>
                </div>
            </div>

            <div class="flex-1 overflow-y-auto">
                @if ($mealPlans->isEmpty())
                    <p class="text-gray-700">No meal plans found.</p>
                @else
                    <ul class="space-y-4">
                        @foreach ($mealPlans as $mealPlan)
                            <li class="bg-gray-100 p-4 rounded-lg shadow">
                                <a href="{{ route('meal-plans.show', $mealPlan->id) }}" class="text-lg font-semibold text-[#0B2558] hover:underline">
                                    {{ $mealPlan->name }}
                                </a>
                                <p class="text-gray-600 text-sm mt-1">{{ Str::limit($mealPlan->description, 100) }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection