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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $trainingProgram->title }}</h1>
                <div class="flex gap-2">
                    @if(auth()->id() === $trainingProgram->coach_id || auth()->user()->role === 'admin')
                    <a href="{{ route('training-programs.edit', $trainingProgram) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
                        Edit Program
                    </a>
                    @endif
                    <a href="{{ route('training-programs.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Back to List
                    </a>
                </div>
            </div>

            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('success') }}
            </div>
            @endif

            <!-- Program Details -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="md:col-span-2">
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h2 class="text-xl font-semibold mb-4">Program Details</h2>
                        
                        <div class="mb-4">
                            <h3 class="text-lg font-medium mb-2">Description</h3>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                {!! $trainingProgram->description !!}
                            </div>
                        </div>
                        
                        <div class="mb-4">
                            <h3 class="text-lg font-medium mb-2">To-Do List</h3>
                            <div class="bg-white p-4 rounded-lg border border-gray-200">
                                @if(!empty($trainingProgram->todo_list))
                                    <ul class="list-disc pl-5 space-y-1">
                                        @foreach($trainingProgram->todo_list as $item)
                                            <li class="flex items-start gap-2">
                                                <span>{{ $item }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-500">No to-do items added yet.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h2 class="text-xl font-semibold mb-4">Program Info</h2>
                        
                        <div class="space-y-4">
                            <div>
                                <p class="text-sm text-gray-500">Status</p>
                                <p class="font-medium">
                                    <span class="px-2 py-1 rounded text-white 
                                        {{ $trainingProgram->status === 'active' ? 'bg-green-500' : 
                                        ($trainingProgram->status === 'cancelled' ? 'bg-red-500' : 'bg-blue-500') }}">
                                        {{ ucfirst($trainingProgram->status) }}
                                    </span>
                                </p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Coach</p>
                                <p class="font-medium">{{ $trainingProgram->coach->name }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Total Sessions</p>
                                <p class="font-medium">{{ $trainingProgram->total_sessions }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Created</p>
                                <p class="font-medium">{{ $trainingProgram->created_at->format('M d, Y') }}</p>
                            </div>
                            
                            <div>
                                <p class="text-sm text-gray-500">Last Updated</p>
                                <p class="font-medium">{{ $trainingProgram->updated_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection