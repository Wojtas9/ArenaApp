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
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-1"></div>

    <div class="flex mt-30 mb-30 h-240 max-w-[1400px] mx-auto gap-5 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [            ],
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
        ])

        <!-- Main Content -->

        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg drop-shadow-xl/50">

            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">Manage your folders</h1>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search something..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-200">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">7</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Logout</button>
                    </form>
                </div>
            </div>

            <!-- Folder Grid -->
            <div class="grid grid-cols-3 gap-6 mb-8">
                <div class="p-6 bg-[#0b2558] text-white rounded-xl">
                    <span class="text-2xl block mb-4">8</span>
                    <h3>Marketing</h3>
                    <p class="text-sm opacity-70">124 MB</p>
                </div>
                <div class="p-6 bg-[#8C508F] text-white rounded-xl">
                    <span class="text-2xl block mb-4">9</span>
                    <h3>Branding</h3>
                    <p class="text-sm opacity-70">124 MB</p>
                </div>
                <div class="p-6 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center">
                    <span class="text-4xl"> 
                        <a href="{{ route('messages.index') }}" class="list-group-item list-group-item-action">
                        Messages 
                    </a>
                    </span>
                </div>
            </div>

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

                <!-- Last Files -->
                <div class="p-6 bg-white rounded-xl shadow-sm">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="font-semibold">Last Files</h3>
                        <span>13</span>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                            <div class="flex items-center gap-3">
                                <span class="text-xl">14</span>
                                <div>
                                    <p class="font-medium">Travel Images.psd</p>
                                    <p class="text-sm text-gray-500">Nov 7, 2021</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>15</span>
                                <span>+7</span>
                            </div>
                        </div>
                        <!-- More file items with placeholders 16-20 -->
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>

</div>
@endsection
