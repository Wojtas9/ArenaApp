@extends('layouts.app')

@section('content')
<video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-1"></div>
<div class="flex h-screen max-w-[1400px] mx-auto gap-6 relative z-20 py-8">

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
            <h1 class="text-2xl font-bold text-gray-900">My Diet</h1>
            <!-- Add Diet specific buttons/controls here -->
        </div>

        <div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-[#0B2558]">My Diet Dashboard</h1>

    {{-- Nutritional Summary --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">Nutritional Summary Today</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="p-4 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-600">Calories</p>
                <p class="text-lg font-bold text-[#8C508F]">0 <span class="text-sm font-normal">kcal</span></p>
            </div>
            <div class="p-4 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-600">Protein</p>
                <p class="text-lg font-bold text-[#8C508F]">0 <span class="text-sm font-normal">g</span></p>
            </div>
            <div class="p-4 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-600">Carbs</p>
                <p class="text-lg font-bold text-[#8C508F]">0 <span class="text-sm font-normal">g</span></p>
            </div>
            <div class="p-4 bg-gray-100 rounded-lg">
                <p class="text-sm text-gray-600">Fats</p>
                <p class="text-lg font-bold text-[#8C508F]">0 <span class="text-sm font-normal">g</span></p>
            </div>
        </div>
        {{-- Data will be dynamically loaded here --}}
    </div>

    {{-- Progress Charts --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">Progress Over Time</h2>
        {{-- Placeholder for charts --}}
        <div class="h-54 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
            Chart visualization will be implemented here.
        </div>
    </div>

    {{-- Quick Access to Meal Plans --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">My Meal Plans</h2>
        
        
        <div class="mt-4 flex justify-between items-center">
        <button onclick="window.location='{{ route('meal-plans.index') }}'" class="bg-[#cf5b44] text-white px-4 py-2 rounded-lg shadow hover:bg-[#b54a36] transition duration-200 float-left">View All Meal Plans</button>
        <button id="openDietPlanModal" class="float-left bg-[#cf5b44] text-white px-4 py-2 rounded-lg shadow hover:bg-[#b54a36] transition duration-200 ">Add Meal Plan</button>
            
        </div>
    </div>

     {{-- Quick Access to Nutritional Goals --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mt-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">My Nutritional Goals</h2>
        {{-- Placeholder for nutritional goals link --}}
        <p class="text-gray-700">Set and track your daily nutritional targets.</p>
        <div class="mt-4 flex justify-between items-center">
            <button onclick="window.location='{{ route('diet.nutritional-goals.index') }}" class="bg-[#cf5b44] text-white px-4 py-2 rounded-lg shadow hover:bg-[#b54a36] transition duration-200 float-left">Manage Nutritional Goals</button>
            <button id="openNutritionalGoalModal" class="float-left bg-[#cf5b44] text-white px-4 py-2 rounded-lg shadow hover:bg-[#b54a36] transition duration-200 ">Add Nutritional Goal</button>
        </div>
    </div>
</div>
        <!-- Add Diet specific content here -->
        
    </div>
</div>

<style>
    /* Add Diet specific styling here, or keep general styles */
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add Diet specific JavaScript here

        const nutritionalGoalModal = document.getElementById('nutritionalGoalModal');
        const dietPlanModal = document.getElementById('dietPlanModal');
        const openNutritionalGoalModalBtn = document.getElementById('openNutritionalGoalModal');
        const openDietPlanModalBtn = document.getElementById('openDietPlanModal');

        // Function to close modals when clicking outside
        window.onclick = function(event) {
            if (event.target == nutritionalGoalModal) {
                nutritionalGoalModal.classList.add('hidden');
            }
            if (event.target == dietPlanModal) {
                dietPlanModal.classList.add('hidden');
            }
        }

        // Open Nutritional Goal Modal
        if(openNutritionalGoalModalBtn) {
            openNutritionalGoalModalBtn.onclick = function() {
                console.log('Nutritional Goal button clicked');
                nutritionalGoalModal.classList.remove('hidden');
                // nutritionalGoalModal.style.display = 'block'; // Tailwind handles display
            }
        }

        // Open Diet Plan Modal
        if(openDietPlanModalBtn) {
            openDietPlanModalBtn.onclick = function() {
                console.log('Diet Plan button clicked');
                dietPlanModal.classList.remove('hidden');
                // dietPlanModal.style.display = 'block'; // Tailwind handles display
            }
        }

        // Close modals with a close button inside the modal
        const closeButtons = document.querySelectorAll('.close-modal');
        closeButtons.forEach(btn => {
            btn.onclick = function() {
                btn.closest('.fixed').classList.add('hidden');
            }
        });
    });
</script>

<!-- Nutritional Goal Modal -->
<div id="nutritionalGoalModal" class="fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity"></div>
    <div class="relative mx-auto p-0 w-full max-w-md shadow-xl rounded-2xl bg-white z-[60] overflow-hidden transform transition-all animate-fade-in" style="margin-top: 10vh;">
        <div class="bg-[#8C508F] p-4 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Create Nutritional Goal</h3>
                <button class="close-modal text-white hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-5">
            @include('diet.nutritional-goals.create')
        </div>
    </div>
</div>

<!-- Diet Plan Modal -->
<div id="dietPlanModal" class="fixed inset-0 hidden overflow-y-auto h-full w-full z-50">
    <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity"></div>
    <div class="relative mx-auto p-0 w-full max-w-md shadow-xl rounded-2xl bg-white z-[60] overflow-hidden transform transition-all animate-fade-in" style="margin-top: 10vh;">
        <div class="bg-[#cf5b44] p-4 text-white">
            <div class="flex justify-between items-center">
                <h3 class="text-xl font-semibold">Create Meal Plan</h3>
                <button class="close-modal text-white hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </div>
        <div class="p-5">
            @include('diet.diet-plans.create')
        </div>
    </div>
</div>

@endsection