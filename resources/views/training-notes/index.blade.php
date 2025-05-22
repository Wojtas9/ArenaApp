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
                <h1 class="text-2xl font-bold">My Training Notes</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('training-notes.create') }}" class="px-4 py-2 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                        Add New Note
                    </a>
                    <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- Training Notes List -->
            <div class="mt-6">
                @if(session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                @if($trainingNotes->isEmpty())
                    <div class="text-center py-8">
                        <p class="text-gray-500 mb-4">You haven't created any training notes yet.</p>
                        <a href="{{ route('training-notes.create') }}" class="px-4 py-2 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                            Create Your First Note
                        </a>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">Title</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Duration</th>
                                    <th class="py-3 px-4 text-left">Intensity</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($trainingNotes as $note)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-3 px-4">{{ $note->title }}</td>
                                    <td class="py-3 px-4">{{ $note->training_date->format('M d, Y') }}</td>
                                    <td class="py-3 px-4">{{ $note->duration ?? '-' }} min</td>
                                    <td class="py-3 px-4">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($note->intensity == 'low') bg-green-100 text-green-800 
                                            @elseif($note->intensity == 'medium') bg-yellow-100 text-yellow-800 
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($note->intensity) }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('training-notes.show', $note) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                            <a href="{{ route('training-notes.edit', $note) }}" class="text-green-500 hover:text-green-700">Edit</a>
                                            <form action="{{ route('training-notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this note?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $trainingNotes->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection