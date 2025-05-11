@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Admin Dashboard</div>

                <div class="card-body">
                    <div class="list-group">
                        <a href="{{ route('spots.index') }}" class="list-group-item list-group-item-action">
                            Manage Sports Halls
                        </a>
                        <!-- Add other admin options here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#ebebeb] mt-15 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-5 relative z-20">
        <!-- Sidebar -->
        <div class="w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-4xl shadow-lg drop-shadow-xl/50">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
                    <span class="text-xl">👨‍💼</span>
                </div>
                <div>
                    <h3 class="font-semibold">Admin Name</h3>
                    <p class="text-sm opacity-70"></p>
                </div>
            </div>

            <nav class="space-y-4">
                <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                    <span class="text-xl">📊</span>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">📁</span>
                    <span>Folders</span>
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">👥</span>
                    <span>User Management</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">⚙️</span>
                    <span>Settings</span>
                </a>
            </nav>

            <div class="mt-8 p-4 border border-[#8C508F] rounded-lg">
                <span class="text-xl block mb-2">6</span>
                <p class="text-sm">Add files</p>
                <p class="text-xs opacity-70">Up to 20 GB</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
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
                    <span class="text-4xl">10</span>
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