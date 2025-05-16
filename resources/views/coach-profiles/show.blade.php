@extends('layouts.app')

@section('content')
    <div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden min-h-screen">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0"
            style="min-width:100vw;min-height:100vh;">
            <source src="/movies/hero_animation.mp4" type="video/mp4">
        </video>
        <div class="fixed inset-0 bg-black/50 z-10"></div>
        <div class="flex flex-col md:flex-row max-w-[1400px] mx-auto gap-6 relative z-20">
            <!-- Sidebar -->
            <div
                class="w-full md:w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-4xl shadow-lg drop-shadow-xl/50 flex-shrink-0">
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
                    <a href="{{ route('coach.dashboard') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                        <span class="text-xl">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('coach-profiles.show', auth()->id()) }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">👤</span>
                        <span>My Profile</span>
                    </a>
                    <a href="{{ route('messages.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">📩</span>
                        <span>Messages</span>
                    </a>
                    <a href="{{ route('spots.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">🏟️</span>
                        <span>Sports Halls</span>
                    </a>
                    <a href="{{ route('training-programs.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">📚</span>
                        <span>Training Programs</span>
                    </a>
                </nav>

                <div class="mt-8">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-2">
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
                    <h1 class="text-2xl font-bold">Coach Profile</h1>
                    <div class="flex items-center gap-4">
                        <a href="{{ route('coach-profiles.edit', ['id' => $coach->id]) }}"
                            class="bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-lg transition-colors flex items-center gap-2">
                            <span class="text-xl">✏️</span>
                            <span>Edit Profile</span>
                        </a>
                    </div>
                </div>

                <!-- Profile Content -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Profile Image -->
                    <div class="col-span-1">
                        <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                            <div class="flex flex-col items-center">
                                @if ($coach->coachProfile && $coach->coachProfile->photo)
                                    <img src="{{ asset('storage/' . $coach->coachProfile->photo) }}?v={{ time() }}"
                                        alt="{{ $coach->name }}" class="w-48 h-48 object-cover rounded-full mb-4">
                                @else
                                    <div
                                        class="w-48 h-48 rounded-full bg-[#8C508F] flex items-center justify-center text-white text-5xl mb-4">
                                        {{ substr($coach->name, 0, 1) }}
                                    </div>
                                @endif
                                <h2 class="text-xl font-bold">{{ $coach->name }}</h2>
                                @if ($coach->coachProfile)
                                    @if($coach->coachProfile->title)
                                        <p class="text-gray-600 mt-2">{{ $coach->coachProfile->title }}</p>
                                    @endif
                                    <p class="text-gray-600 mt-1">{{ $coach->email }}</p>
                                    @if ($coach->coachProfile->phone)
                                        <p class="text-gray-600 mt-1">Phone: {{ $coach->coachProfile->phone }}</p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Coach Bio and Details -->
                    <div class="col-span-2">
                        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                            <h3 class="text-lg font-semibold mb-4">About</h3>
                            <div class="prose max-w-none">
                                @if ($coach->coachProfile && $coach->coachProfile->description)
                                    <p>{{ $coach->coachProfile->description }}</p>
                                @else
                                    <p class="text-gray-500">No description available.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Specializations -->
                        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                            <h3 class="text-lg font-semibold mb-4">Specializations</h3>
                            @if ($coach->coachProfile && $coach->coachProfile->specialty)
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $coach->coachProfile->specialty) as $specialization)
                                        <span
                                            class="bg-purple-100 text-purple-800 px-3 py-1 rounded-full text-sm">{{ trim($specialization) }}</span>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No specializations listed.</p>
                            @endif
                        </div>

                        <!-- Favorite Halls -->
                        <div class="bg-white p-6 rounded-xl shadow-sm mb-6">
                            <h3 class="text-lg font-semibold mb-4">Favorite Halls</h3>
                            @if ($coach->coachProfile && $coach->coachProfile->favorite_halls)
                                <p>{{ $coach->coachProfile->favorite_halls }}</p>
                            @else
                                <p class="text-gray-500">No favorite halls listed.</p>
                            @endif
                        </div>

                        <!-- Accessibility -->
                        <div class="bg-white p-6 rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold mb-4">Accessibility</h3>
                            @if ($coach->coachProfile && $coach->coachProfile->accessibility)
                                <p>{{ $coach->coachProfile->accessibility }}</p>
                            @else
                                <p class="text-gray-500">No accessibility information available.</p>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
