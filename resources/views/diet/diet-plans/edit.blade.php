@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Diet Plan</h1>

    <form action="{{ route('diet.diet-plans.update', $dietPlan) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nutritional_goal_id" class="block text-gray-700 text-sm font-bold mb-2">Nutritional Goal:</label>
            <select name="nutritional_goal_id" id="nutritional_goal_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="">Select a Nutritional Goal</option>
                @foreach($nutritionalGoals as $goal)
                    <option value="{{ $goal->id }}" {{ old('nutritional_goal_id', $dietPlan->nutritional_goal_id) == $goal->id ? 'selected' : '' }}>
                        {{ $goal->start_date->format('Y-m-d') }} to {{ $goal->end_date ? $goal->end_date->format('Y-m-d') : 'Present' }} ({{ $goal->target_calories }} Calories)
                    </option>
                @endforeach
            </select>
            @error('nutritional_goal_id')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Plan Name:</label>
            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('name', $dietPlan->name) }}" required>
            @error('name')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32 resize-none">{{ old('description', $dietPlan->description) }}</textarea>
            @error('description')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('start_date', $dietPlan->start_date->format('Y-m-d')) }}" required>
            @error('start_date')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
            <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('end_date', $dietPlan->end_date ? $dietPlan->end_date->format('Y-m-d') : '') }}">
            @error('end_date')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-4">
            <label for="status" class="block text-gray-700 text-sm font-bold mb-2">Status:</label>
            <select name="status" id="status" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                <option value="active" {{ old('status', $dietPlan->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="completed" {{ old('status', $dietPlan->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="archived" {{ old('status', $dietPlan->status) == 'archived' ? 'selected' : '' }}>Archived</option>
            </select>
            @error('status')
                <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="bg-[#8C508F] hover:bg-[#7a457d] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Update Plan</button>
    </form>
</div>
@endsection