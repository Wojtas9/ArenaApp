@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Nutritional Goal</h1>

    <form action="{{ route('diet.nutritional-goals.update', $nutritionalGoal) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="target_calories" class="block text-gray-700 text-sm font-bold mb-2">Target Calories:</label>
            <input type="number" name="target_calories" id="target_calories" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('target_calories', $nutritionalGoal->target_calories) }}" required>
            @error('target_calories')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="target_proteins" class="block text-gray-700 text-sm font-bold mb-2">Target Proteins (g):</label>
            <input type="number" step="0.1" name="target_proteins" id="target_proteins" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('target_proteins', $nutritionalGoal->target_proteins) }}" required>
            @error('target_proteins')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="target_carbohydrates" class="block text-gray-700 text-sm font-bold mb-2">Target Carbohydrates (g):</label>
            <input type="number" step="0.1" name="target_carbohydrates" id="target_carbohydrates" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('target_carbohydrates', $nutritionalGoal->target_carbohydrates) }}" required>
            @error('target_carbohydrates')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="target_fats" class="block text-gray-700 text-sm font-bold mb-2">Target Fats (g):</label>
            <input type="number" step="0.1" name="target_fats" id="target_fats" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('target_fats', $nutritionalGoal->target_fats) }}" required>
            @error('target_fats')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('start_date', $nutritionalGoal->start_date->format('Y-m-d')) }}" required>
            @error('start_date')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('end_date', $nutritionalGoal->end_date ? $nutritionalGoal->end_date->format('Y-m-d') : '') }}">
            @error('end_date')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="active" {{ old('status', $nutritionalGoal->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $nutritionalGoal->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="archived" {{ old('status', $nutritionalGoal->status) == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
            <textarea name="notes" id="notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32 resize-none">{{ old('notes', $nutritionalGoal->notes) }}</textarea>
            @error('notes')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-[#8C508F] hover:bg-[#7a457d] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Goal</button>
    </form>
</div>
@endsection