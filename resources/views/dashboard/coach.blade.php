@extends('layouts.app')

@section('content')
<div class="flex h-270 max-w-[1400px] mx-auto gap-6">
    <!-- Sidebar -->
    <div class="w-64 bg-[#0B2558] text-white p-6 rounded-2xl shadow-lg">
        <div class="flex items-center gap-3 mb-8">
            <div class="w-12 h-12 rounded-full bg-[#1a3a7a] flex items-center justify-center">
                <span class="text-xl">👨‍🏫</span>
            </div>
            <div>
                <h3 class="font-semibold">Coach Name</h3>
                <p class="text-sm opacity-70">Coach</p>
            </div>
        </div>

        <nav class="space-y-4">
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#1a3a7a] transition-colors">
                <span class="text-xl">📊</span>
                <span>Dashboard</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#1a3a7a] transition-colors">
                <span class="text-xl">📁</span>
                <span>Folders</span>
            </a>
            <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#1a3a7a] transition-colors">
                <span class="text-xl">⚙️</span>
                <span>Settings</span>
            </a>
        </nav>

        <div class="mt-8 p-4 border border-[#1a3a7a] rounded-lg">
            <span class="text-xl block mb-2">📤</span>
            <p class="text-sm">Add files</p>
            <p class="text-xs opacity-70">Up to 20 GB</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">Manage your folders</h1>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" placeholder="Search something..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-200">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Logout</button>
                </form>
            </div>
        </div>

        <!-- Folder Grid -->
        <div class="grid grid-cols-3 gap-6 mb-8">
            <div class="p-6 bg-[#0B2558] text-white rounded-xl">
                <span class="text-2xl block mb-4">📊</span>
                <h3>Training Plans</h3>
                <p class="text-sm opacity-70">124 MB</p>
            </div>
            <div class="p-6 bg-[#1a3a7a] text-white rounded-xl">
                <span class="text-2xl block mb-4">📋</span>
                <h3>Team Stats</h3>
                <p class="text-sm opacity-70">124 MB</p>
            </div>
            <div class="p-6 bg-gray-100 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center">
                <span class="text-4xl">➕</span>
            </div>
        </div>

        <!-- Storage and Files Section -->
        <div class="grid grid-cols-2 gap-6">
            <!-- Storage Overview -->
            <div class="p-6 bg-white rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-semibold">Storage</h3>
                    <span>📊</span>
                </div>
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="text-2xl font-bold">37%</span>
                    </div>
                    <span>📈</span>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-[#0B2558]"></span>
                            <span>Documents</span>
                        </span>
                        <span>68 GB</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-[#1a3a7a]"></span>
                            <span>Images</span>
                        </span>
                        <span>315 GB</span>
                    </div>
                </div>
            </div>

            <!-- Last Files -->
            <div class="p-6 bg-white rounded-xl shadow-sm">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="font-semibold">Last Files</h3>
                    <span>📄</span>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📊</span>
                            <div>
                                <h4 class="font-medium">Training Schedule</h4>
                                <p class="text-xs text-gray-500">PDF • 2.3 MB</p>
                            </div>
                        </div>
                        <span>⋮</span>
                    </div>
                    <div class="flex items-center justify-between p-3 hover:bg-gray-50 rounded-lg transition-colors">
                        <div class="flex items-center gap-3">
                            <span class="text-xl">📋</span>
                            <div>
                                <h4 class="font-medium">Team Roster</h4>
                                <p class="text-xs text-gray-500">XLSX • 1.8 MB</p>
                            </div>
                        </div>
                        <span>⋮</span>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sports Halls Management Link -->
        <div class="mt-8 p-4 bg-gray-50 rounded-lg">
            <a href="{{ route('spots.index') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] hover:text-white transition-colors">
                <span class="text-xl">🏟️</span>
                <span>Manage Sports Halls</span>
            </a>
        </div>
    </div>
</div>
@endsection