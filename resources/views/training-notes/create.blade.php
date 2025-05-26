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
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '🏃',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Add New Training Note</h1>
                <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            </div>

            <!-- Form -->
            <form action="{{ route('training-notes.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                        @error('title')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="training_date" class="block text-sm font-medium text-gray-700 mb-1">Training Date</label>
                        <input type="date" name="training_date" id="training_date" value="{{ old('training_date', date('Y-m-d')) }}" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                        @error('training_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="duration" class="block text-sm font-medium text-gray-700 mb-1">Duration (minutes)</label>
                        <input type="number" name="duration" id="duration" value="{{ old('duration') }}" min="1"
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                        @error('duration')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div>
                        <label for="intensity" class="block text-sm font-medium text-gray-700 mb-1">Intensity</label>
                        <select name="intensity" id="intensity" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                            <option value="low" {{ old('intensity') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ old('intensity') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ old('intensity') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                        @error('intensity')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Exercises Field -->
                <div>
                    <label for="exercises" class="block text-sm font-medium text-gray-700 mb-1">Exercises (one per line)</label>
                    <textarea name="exercises" id="exercises" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ old('exercises') }}</textarea>
                    @error('exercises')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                    <textarea name="notes" id="notes" rows="5"
                        class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#8C508F]">{{ old('notes') }}</textarea>
                    @error('notes')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="flex justify-end space-x-4">
                    <a href="{{ route('training-notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </a>
                    <button type="submit" class="px-4 py-2 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                        Save Note
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection