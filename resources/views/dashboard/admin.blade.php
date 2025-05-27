@extends('layouts.app')

@section('content')
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        @vite('resources/css/app.css')
    </head>

    <body class="bg-[#ebebeb] relative overflow-hidden">

        <div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">

            <!-- Video Background -->
            <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0"
                style="min-width:100vw;min-height:100vh;">
                <source src="/movies/hero_animation.mp4" type="video/mp4">
            </video>
            <div class="fixed inset-0 bg-black/50 z-1"></div>

            <div class="flex mt-30 mb-30 h-240 max-w-[1400px] mx-auto gap-5 relative z-20">
                <!-- Sidebar -->
                @include('layouts.partials.sidebar', [
                    'sidebarIcon' => '👨‍💼',
                    'sidebarTitle' => Auth::user()->name,
                    'sidebarSubtitle' => ucfirst(Auth::user()->role),
                    'navLinks' => [],
                    // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
                ])

                <!-- Main Content -->
                <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg drop-shadow-xl/50">
                    <!-- Top Bar -->
                    <div class="flex justify-between items-center mb-8">
                        <h1 class="text-2xl font-bold">Coach Dashboard</h1>
                        <div class="flex items-center gap-4">
                            <div class="relative">
                                <input type="text" placeholder="Search..."
                                    class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
                            </div>
                            <div class="w-10 h-10 rounded-full bg-[#8C508F] flex items-center justify-center text-white">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats Section -->
                    <div class="mb-6 bg-gradient-to-br from-white to-gray-50 p-6 rounded-xl shadow-lg border border-gray-100 w-full">
                        <h2 class="text-2xl font-bold mb-6 text-gray-800 flex items-center gap-3 border-b pb-3">
                            <span class="text-3xl">📊</span> System Overview
                            <span class="text-sm font-normal text-gray-500 ml-auto">Platform Statistics</span>
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <div class="bg-gradient-to-br from-blue-50 to-white p-4 rounded-lg shadow border-l-4 border-blue-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-md font-semibold text-blue-600 group-hover:text-blue-700">Total Users</p>
                                        <p class="text-3xl font-bold text-gray-800 mt-2">
                                            {{ \App\Models\User::count() }}</p>
                                    </div>
                                    <span class="text-3xl text-blue-500 group-hover:scale-110 transition-transform">👥</span>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-purple-50 to-white p-4 rounded-lg shadow border-l-4 border-purple-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-md font-semibold text-purple-600 group-hover:text-purple-700">Total Programs</p>
                                        <p class="text-3xl font-bold text-gray-800 mt-2">
                                            {{ \App\Models\TrainingProgram::count() }}
                                        </p>
                                    </div>
                                    <span class="text-3xl text-purple-500 group-hover:scale-110 transition-transform">📚</span>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-yellow-50 to-white p-4 rounded-lg shadow border-l-4 border-yellow-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-md font-semibold text-yellow-600 group-hover:text-yellow-700">Total Spots</p>
                                        <p class="text-3xl font-bold text-gray-800 mt-2">
                                            {{ \App\Models\Spot::count() }}</p>
                                    </div>
                                    <span class="text-3xl text-yellow-500 group-hover:scale-110 transition-transform">🏟️</span>
                                </div>
                            </div>

                            <div class="bg-gradient-to-br from-red-50 to-white p-4 rounded-lg shadow border-l-4 border-red-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-md font-semibold text-red-600 group-hover:text-red-700">Total Events</p>
                                        <p class="text-3xl font-bold text-gray-800 mt-2">
                                            {{ \App\Models\Event::count() }}</p>
                                    </div>
                                    <span class="text-3xl text-red-500 group-hover:scale-110 transition-transform">📅</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Quick Stats Section -->

                    <!-- Storage and Files Section -->

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Storage Overview -->
                        <div class="p-6 bg-white rounded-xl shadow-sm">
                            <div class="flex justify-between items-center mb-6">
                                <h3 class="font-semibold">User Roles Distribution</h3>
                            </div>
                            <div class="relative w-64 h-64 mx-auto mb-6">
                                <canvas id="rolesChart"></canvas>

                            </div>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-[#CF5B44]"></span>

                                        <span>Admin</span>
                                    </span>
                                    <span>{{ $roleStats['admin'] }} users</span>

                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-[#8C508F]"></span>

                                        <span>Coach</span>
                                    </span>
                                    <span>{{ $roleStats['coach'] }} users</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="flex items-center gap-2">
                                        <span class="w-3 h-3 rounded-full bg-[#0b2558]"></span>
                                        <span>Player</span>
                                    </span>
                                    <span>{{ $roleStats['player'] }} users</span>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
    </body>

    </html>
    </div>
@endsection
