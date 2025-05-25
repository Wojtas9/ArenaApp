<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Player Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '🍎', 'text' => 'My Diet', 'href' => route('diet.index'), 'active_check_route_name' => 'diet.index'],
                
            ],
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
        ])

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
                <div class="p-6 bg-[#2E7D32] text-white rounded-xl">
                    <span class="text-2xl block mb-4">📊</span>
                    <h3>Performance</h3>
                    <p class="text-sm opacity-70">124 MB</p>
                </div>
                <div class="p-6 bg-[#4CAF50] text-white rounded-xl">
                    <span class="text-2xl block mb-4">📋</span>
                    <h3>Training</h3>
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
                                <span class="w-3 h-3 rounded-full bg-[#2E7D32]"></span>
                                <span>Documents</span>
                            </span>
                            <span>68 GB</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full bg-[#4CAF50]"></span>
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
                                    <p class="font-medium">Performance Report.pdf</p>
                                    <p class="text-sm text-gray-500">Nov 7, 2023</p>
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>👥</span>
                                <span>+7</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>


