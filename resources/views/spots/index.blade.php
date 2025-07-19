@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
    @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => []
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
            ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Spots</h1>
                <div class="flex items-center gap-4">
                    <a href="{{ route('spots.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        Add New Spot
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                    </form>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white dark:bg-gray-800">
                    <thead>
                        <tr class="bg-gray-100 dark:bg-gray-700">
                            <th class="py-3 px-4 text-left">Picture</th>
                            <th class="py-3 px-4 text-left">Name</th>
                            <th class="py-3 px-4 text-left">Location</th>
                            <th class="py-3 px-4 text-left">Capacity</th>
                            <th class="py-3 px-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spots as $spot)
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-3 px-4">
                                @if($spot->picture)
                                    <img src="{{ asset($spot->picture) }}" alt="Spot Picture" class="h-16 w-16 object-cover rounded">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="py-3 px-4">{{ $spot->name }}</td>
                            <td class="py-3 px-4">{{ $spot->location }}</td>
                            <td class="py-3 px-4">{{ $spot->capacity }}</td>
                            <td class="py-3 px-4 flex justify-center space-x-2">
                                <a href="{{ route('spots.edit', $spot) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                                <form action="{{ route('spots.destroy', $spot) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this sports hall?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-3 px-4 text-center">No spot found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $spots->links() }}
            </div>
        </div>
    </div>
</div>
@endsection