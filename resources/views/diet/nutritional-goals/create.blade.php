<h1>Create Nutritional Goal</h1>

<form action="{{ route('diet.nutritional-goals.store') }}" method="POST">
    @csrf

    <div class="mb-4">
        <label for="daily_calories_target" class="block text-gray-700 text-sm font-bold mb-2">Target Calories:</label>
        <input type="number" name="daily_calories_target" id="daily_calories_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('daily_calories_target') }}" required>
        @error('daily_calories_target')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="daily_proteins_target" class="block text-gray-700 text-sm font-bold mb-2">Target Proteins (g):</label>
        <input type="number" step="0.1" name="daily_proteins_target" id="daily_proteins_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('daily_proteins_target') }}" required>
        @error('daily_proteins_target')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="daily_carbohydrates_target" class="block text-gray-700 text-sm font-bold mb-2">Target Carbohydrates (g):</label>
        <input type="number" step="0.1" name="daily_carbohydrates_target" id="daily_carbohydrates_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('daily_carbohydrates_target') }}" required>
        @error('daily_carbohydrates_target')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="daily_fats_target" class="block text-gray-700 text-sm font-bold mb-2">Target Fats (g):</label>
        <input type="number" step="0.1" name="daily_fats_target" id="daily_fats_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('daily_fats_target') }}" required>
        @error('daily_fats_target')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="daily_fiber_target" class="block text-gray-700 text-sm font-bold mb-2">Target Fiber (g):</label>
        <input type="number" step="0.1" name="daily_fiber_target" id="daily_fiber_target" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('daily_fiber_target') }}">
        @error('daily_fiber_target')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="dietary_restrictions" class="block text-gray-700 text-sm font-bold mb-2">Dietary Restrictions:</label>
        <textarea name="dietary_restrictions" id="dietary_restrictions" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-24 resize-none">{{ old('dietary_restrictions') }}</textarea>
        @error('dietary_restrictions')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Start Date:</label>
        <input type="date" name="start_date" id="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('start_date') }}" required>
        @error('start_date')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">End Date:</label>
        <input type="date" name="end_date" id="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ old('end_date') }}">
        @error('end_date')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="notes" class="block text-gray-700 text-sm font-bold mb-2">Notes:</label>
        <textarea name="notes" id="notes" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline h-32 resize-none">{{ old('notes') }}</textarea>
        @error('notes')
            <div class="text-red-500 text-xs italic mt-1">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="bg-[#8C508F] hover:bg-[#7a457d] text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Create Goal</button>
</form>