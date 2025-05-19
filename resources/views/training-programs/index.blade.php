@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden min-h-screen">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex flex-col md:flex-row max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '👥', 'text' => 'User Management', 'href' => route('admin.users'), 'active_check_route_name' => 'admin.users'],
                ['icon' => '🏟️', 'text' => 'Spots Management', 'href' => route('spots.index'), 'active_check_route_name' => 'spots.index'],
                ['icon' => '📚', 'text' => 'Training Programs', 'href' => '#', 'active_check_route_name' => 'training-programs.settings'] 
            ],
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50 min-h-[500px]">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Training Programs</h1>
                @if(auth()->user()->role === 'coach' || auth()->user()->role === 'admin')
                <a href="{{ route('training-programs.create') }}" class="bg-[#cf5b44] hover:bg-[#b84c38] text-white px-4 py-2 rounded-lg">
                    Create New Program
                </a>
                @endif
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
            @endif

            @if(count($programs) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="py-3 px-4 text-left">Title</th>
                            <th class="py-3 px-4 text-left">Coach</th>
                            <th class="py-3 px-4 text-left">Status</th>
                            <th class="py-3 px-4 text-left">Sessions</th>
                            <th class="py-3 px-4 text-left">Created</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($programs as $program)
                        <tr class="hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <a href="{{ route('training-programs.show', $program) }}" class="text-blue-600 hover:text-blue-800 font-medium">
                                    {{ $program->title }}
                                </a>
                            </td>
                            <td class="py-3 px-4">{{ $program->coach->name }}</td>
                            <td class="py-3 px-4">
                                <span class="px-2 py-1 rounded text-white 
                                    {{ $program->status === 'active' ? 'bg-green-500' : 
                                    ($program->status === 'cancelled' ? 'bg-red-500' : 'bg-blue-500') }}">
                                    {{ ucfirst($program->status) }}
                                </span>
                            </td>
                            <td class="py-3 px-4">{{ $program->total_sessions }}</td>
                            <td class="py-3 px-4">{{ $program->created_at->format('M d, Y') }}</td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('training-programs.show', $program) }}" class="text-blue-500 hover:text-blue-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    @if(auth()->user()->id === $program->coach_id || auth()->user()->role === 'admin')
                                    <a href="{{ route('training-programs.edit', $program) }}" class="text-yellow-500 hover:text-yellow-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </a>
                                    
                                    <form action="{{ route('training-programs.destroy', $program) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this program?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $programs->links() }}
            </div>
            @else
            <div class="bg-gray-100 p-6 rounded-lg text-center">
                <p class="text-gray-700">No training programs found.</p>
                @if(auth()->user()->role === 'coach' || auth()->user()->role === 'admin')
                <a href="{{ route('training-programs.create') }}" class="inline-block mt-4 bg-[#cf5b44] hover:bg-[#b84c38] text-white px-4 py-2 rounded-lg">
                    Create Your First Program
                </a>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection