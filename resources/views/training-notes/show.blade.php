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
                <div class="flex items-center gap-3">
                    <a href="{{ route('training-notes.index') }}" class="text-gray-500 hover:text-gray-700">
                        <span class="text-xl">←</span>
                    </a>
                    <h1 class="text-2xl font-bold">{{ $trainingNote->title }}</h1>
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('training-notes.edit', $trainingNote) }}" class="px-4 py-2 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                        Edit Note
                    </a>
                    <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- Training Note Details -->
            <div class="bg-gray-50 rounded-xl p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">Training Date</p>
                        <p class="text-lg font-semibold">{{ $trainingNote->training_date->format('M d, Y') }}</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">Duration</p>
                        <p class="text-lg font-semibold">{{ $trainingNote->duration ?? '-' }} minutes</p>
                    </div>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        <p class="text-sm text-gray-500">Intensity</p>
                        <p class="text-lg font-semibold">
                            <span class="px-2 py-1 rounded text-xs 
                                @if($trainingNote->intensity == 'low') bg-green-100 text-green-800 
                                @elseif($trainingNote->intensity == 'medium') bg-yellow-100 text-yellow-800 
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($trainingNote->intensity) }}
                            </span>
                        </p>
                    </div>
                </div>

                @if($trainingNote->description)
                <div class="mb-6">
                    <h3 class="font-semibold mb-2">Description</h3>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        {{ $trainingNote->description }}
                    </div>
                </div>
                @endif

                @if($trainingNote->notes)
                <div>
                    <h3 class="font-semibold mb-2">Additional Notes</h3>
                    <div class="p-4 bg-white rounded-lg shadow-sm">
                        {{ $trainingNote->notes }}
                    </div>
                </div>
                @endif
            </div>

            <div class="flex justify-between">
                <a href="{{ route('training-notes.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                    Back to Notes
                </a>
                <form action="{{ route('training-notes.destroy', $trainingNote) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this note?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                        Delete Note
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection