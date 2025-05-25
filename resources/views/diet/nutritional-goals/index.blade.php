@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-[#0B2558]">My Nutritional Goals</h1>

    {{-- Nutritional Goals Form --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">Set Your Daily Goals</h2>
        {{-- Placeholder for goal setting form --}}
        <form>
            <div class="mb-4">
                <label for="daily-calories" class="block text-gray-700 text-sm font-bold mb-2">Daily Calories Target (kcal):</label>
                <input type="number" id="daily-calories" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="protein-target" class="block text-gray-700 text-sm font-bold mb-2">Protein Target (g):</label>
                <input type="number" id="protein-target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="carbs-target" class="block text-gray-700 text-sm font-bold mb-2">Carbs Target (g):</label>
                <input type="number" id="carbs-target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="fats-target" class="block text-gray-700 text-sm font-bold mb-2">Fats Target (g):</label>
                <input type="number" id="fats-target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-[#cf5b44] hover:bg-[#8C508F] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Save Goals
                </button>
            </div>
        </form>
    </div>

    {{-- Progress Tracking Visualization --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">Progress Visualization</h2>
        {{-- Placeholder for charts/graphs --}}
        <div class="h-64 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500">
            Progress tracking visualization will be implemented here.
        </div>
    </div>
</div>
@endsection