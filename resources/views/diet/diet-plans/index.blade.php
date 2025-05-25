@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6 text-[#0B2558]">My Meal Plans</h1>

    {{-- Meal List Section --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 mb-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">My Meals</h2>
        {{-- Placeholder for meal list --}}
        <ul class="list-disc list-inside text-gray-700">
            <li>Sample Meal 1 (Breakfast)</li>
            <li>Sample Meal 2 (Lunch)</li>
            <li>Sample Meal 3 (Dinner)</li>
            {{-- Meals will be listed dynamically here --}}
        </ul>
    </div>

    {{-- Add New Meal Form Section --}}
    <div class="bg-white rounded-2xl shadow-lg p-6 border border-gray-200">
        <h2 class="text-xl font-semibold mb-4 text-[#cf5b44]">Add New Meal</h2>
        {{-- Placeholder for add new meal form --}}
        <form>
            <div class="mb-4">
                <label for="meal-name" class="block text-gray-700 text-sm font-bold mb-2">Meal Name:</label>
                <input type="text" id="meal-name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="meal-time" class="block text-gray-700 text-sm font-bold mb-2">Time:</label>
                <input type="time" id="meal-time" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
            </div>
            <div class="mb-4">
                <label for="meal-description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                <textarea id="meal-description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
            </div>
            <div class="flex items-center justify-between">
                <button type="submit" class="bg-[#cf5b44] hover:bg-[#8C508F] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Add Meal
                </button>
            </div>
        </form>
        {{-- Food item search and selection will be added later --}}
    </div>
</div>
@endsection