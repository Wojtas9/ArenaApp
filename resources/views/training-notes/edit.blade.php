@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Edit Training Note</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('training-notes.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                        Back to Notes
                    </a>
                    <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="bg-gray-50 rounded-xl p-6">
                <form action="{{ route('training-notes.update', $trainingNote) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Training Date -->
                        <div class="col-span-1">
                            <label for="training_date" class="block text-sm font-medium text-gray-700 mb-1">Training Date</label>
                            <input type="date" name="training_date" id="training_date" value="{{ $trainingNote->training_date->format('Y-m-d') }}" 
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]" required>
                            @error('training_date')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Duration -->
                        <div class="col-span-1">
                            <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                            <input type="number" name="duration" id="duration" value="{{ $trainingNote->duration }}" 
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                            @error('duration')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <!-- Intensity -->
                        <div class="col-span-1">
                            <label for="intensity" class="block text-sm font-medium text-gray-700 mb-1">Intensity</label>
                            <select name="intensity" id="intensity" 
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                                <option value="low" {{ $trainingNote->intensity === 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $trainingNote->intensity === 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $trainingNote->intensity === 'high' ? 'selected' : '' }}>High</option>
                            </select>
                            @error('intensity')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Mood -->
                        <div class="col-span-1">
                            <label for="mood" class="block text-sm font-medium text-gray-700 mb-1">Mood</label>
                            <select name="mood" id="mood" 
                                class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                                <option value="great" {{ $trainingNote->mood === 'great' ? 'selected' : '' }}>Great</option>
                                <option value="good" {{ $trainingNote->mood === 'good' ? 'selected' : '' }}>Good</option>
                                <option value="neutral" {{ $trainingNote->mood === 'neutral' ? 'selected' : '' }}>Neutral</option>
                                <option value="tired" {{ $trainingNote->mood === 'tired' ? 'selected' : '' }}>Tired</option>
                                <option value="exhausted" {{ $trainingNote->mood === 'exhausted' ? 'selected' : '' }}>Exhausted</option>
                            </select>
                            @error('mood')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Title -->
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ $trainingNote->title }}" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]" required>
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea name="description" id="description" rows="5" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ $trainingNote->description }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Exercises -->
                    <div class="mb-6">
                        <label for="exercises" class="block text-sm font-medium text-gray-700 mb-1">Exercises (one per line)</label>
                        <textarea name="exercises" id="exercises" rows="5" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ $trainingNote->exercises }}</textarea>
                        @error('exercises')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Notes -->
                    <div class="mb-6">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                        <textarea name="notes" id="notes" rows="3" 
                            class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ $trainingNote->notes }}</textarea>
                        @error('notes')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                            Update Training Note
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection