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
                <tbody class="divide-y divide-gray-200">
                    @foreach(\App\Models\Message::where('recipient_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get() as $message)
                    <tr class="hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $message->subject }}</td>
                        <td class="py-3 px-4">{{ ucfirst($message->status) }}</td>
                        <td class="py-3 px-4">{{ $message->created_at->format('M d, Y') }}</td>
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('messages.show', $message) }}" class="text-blue-500 hover:text-blue-700">View</a>
                                <a href="{{ route('messages.edit', $message) }}" class="text-green-500 hover:text-green-700">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    
                    @if(\App\Models\Message::where('recipient_id', auth()->id())->count() == 0)
                    <tr>
                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">No messages found. Check back later!</td>
                    </tr>
                    @endif
                </tbody>
        
                <!-- Quick Stats Section -->
                <div class="mb-8 bg-gradient-to-br from-white to-gray-50 p-8 rounded-2xl shadow-xl border border-gray-100 w-full">
                    <h2 class="text-3xl font-bold mb-8 text-gray-800 flex items-center gap-3 border-b pb-4">
                        <span class="text-4xl">📊</span> Quick Stats Overview
                        <span class="text-base font-normal text-gray-500 ml-auto">Your Performance at a Glance</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-8">
                        <div class="bg-gradient-to-br from-blue-50 to-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500 transform hover:scale-105 transition-all hover:shadow-2xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-lg font-semibold text-blue-600 group-hover:text-blue-700">Training Notes</p>
                                    <p class="text-4xl font-bold text-gray-800 mt-3">{{ $stats['trainingNotes'] }}</p>
                                </div>
                                <span class="text-4xl text-blue-500 group-hover:scale-110 transition-transform">📝</span>
                            </div>
                        </div>
                
                        <div class="bg-gradient-to-br from-purple-50 to-white p-6 rounded-xl shadow-lg border-l-4 border-purple-500 transform hover:scale-105 transition-all hover:shadow-2xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-lg font-semibold text-purple-600 group-hover:text-purple-700">Coaches</p>
                                    <p class="text-4xl font-bold text-gray-800 mt-3">{{ $stats['coaches'] }}</p>
                                </div>
                                <span class="text-4xl text-purple-500 group-hover:scale-110 transition-transform">👨‍🏫</span>
                            </div>
                        </div>
                
                        <div class="bg-gradient-to-br from-yellow-50 to-white p-6 rounded-xl shadow-lg border-l-4 border-yellow-500 transform hover:scale-105 transition-all hover:shadow-2xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-lg font-semibold text-yellow-600 group-hover:text-yellow-700">Messages</p>
                                    <p class="text-4xl font-bold text-gray-800 mt-3">{{ $stats['messages'] }}</p>
                                </div>
                                <span class="text-4xl text-yellow-500 group-hover:scale-110 transition-transform">✉️</span>
                            </div>
                        </div>
                
                        <div class="bg-gradient-to-br from-red-50 to-white p-6 rounded-xl shadow-lg border-l-4 border-red-500 transform hover:scale-105 transition-all hover:shadow-2xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-lg font-semibold text-red-600 group-hover:text-red-700">Calendar Events</p>
                                    <p class="text-4xl font-bold text-gray-800 mt-3">{{ $stats['events'] }}</p>
                                </div>
                                <span class="text-4xl text-red-500 group-hover:scale-110 transition-transform">📅</span>
                            </div>
                        </div>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</body>

</html>




