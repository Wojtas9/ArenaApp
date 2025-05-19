
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
        <div class="w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-4xl shadow-lg drop-shadow-xl/50">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
                    <span class="text-xl">👨‍🏫</span>
                </div>
                <div>
                    <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                    <p class="text-sm opacity-70">Coach</p>
                </div>
            </div>

            <nav class="space-y-4">
                <a href="{{ route('coach.dashboard') }}" class="flex items-center gap-3 p-3 rounded bg-[#0B2558] transition-colors">
                    <span class="text-xl">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('coach-profiles.show', auth()->id()) }}"
                    class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">📁👤</span>
                    <span>My Profile</span>
                </a>
                <a href="{{ route('calendar') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#1a3a7a] transition-colors">
                <span class="text-xl">📅</span>
                <span>Calendar</span>
                </a>
                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">📩</span>
                    <span>Messages</span>
                </a>
                <a href="{{ route('spots.index') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">🏟️</span>
                    <span>Sports Halls</span>
                </a>
                <a href="{{ route('training-programs.index') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">📚</span>
                    <span>Training Programs</span>
                </a>
            </nav>

            <div class="mt-8">
                <form action="{{ route('logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-2">
                        <span class="text-xl">🚪</span>
                        <span>Logout</span>
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Coach Dashboard</h1>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                        <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                </div>
            </div>

            <!-- Dashboard Content -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Quick Stats -->
                <div class="p-6 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="font-semibold mb-4">Quick Stats</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Total Programs</p>
                            <p class="text-2xl font-bold">{{ \App\Models\TrainingProgram::where('coach_id', auth()->id())->count() }}</p>
                        </div>
                        <div class="p-4 bg-white rounded-lg shadow-sm">
                            <p class="text-sm text-gray-500">Active Programs</p>
                            <p class="text-2xl font-bold">{{ \App\Models\TrainingProgram::where('coach_id', auth()->id())->where('status', 'active')->count() }}</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6 bg-gray-50 rounded-xl shadow-sm">
                    <h3 class="font-semibold mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('training-programs.create') }}" class="block p-3 bg-[#8C508F] text-white rounded-lg hover:bg-[#734072] transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">➕</span>
                                <span>Create New Program</span>
                            </div>
                        </a>
                        <a href="{{ route('training-programs.index') }}" class="block p-3 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">📋</span>
                                <span>View All Programs</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Programs Section  -->
            <div class="mt-8">
                <h3 class="text-xl font-bold mb-4">Recent Programs</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white rounded-lg overflow-hidden">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-3 px-4 text-left">Title</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-left">Created</th>
                                <th class="py-3 px-4 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach(\App\Models\TrainingProgram::where('coach_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get() as $program)
                            <tr class="hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $program->title }}</td>
                                <td class="py-3 px-4">{{ ucfirst($program->status) }}</td>
                                <td class="py-3 px-4">{{ $program->created_at->format('M d, Y') }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('training-programs.show', $program) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                        <a href="{{ route('training-programs.edit', $program) }}" class="text-green-500 hover:text-green-700">Edit</a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if(\App\Models\TrainingProgram::where('coach_id', auth()->id())->count() == 0)
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">No programs found. Create your first program!</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

