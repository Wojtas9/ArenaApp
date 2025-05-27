@extends('layouts.app')

@section('content')
    <div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0"
            style="min-width:100vw;min-height:100vh;">
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
                    [
                        'icon' => '🍎',
                        'text' => 'My Diet',
                        'href' => route('diet.index'),
                        'active_check_route_name' => 'diet.index',
                    ],
                ],
                // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
            ])

            <!-- Main Content -->
            <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">Player Dashboard</h1>
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
                        <span class="text-3xl">📊</span> Quick Stats Overview
                        <span class="text-sm font-normal text-gray-500 ml-auto">Your Performance at a Glance</span>
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gradient-to-br from-blue-50 to-white p-4 rounded-lg shadow border-l-4 border-blue-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-md font-semibold text-blue-600 group-hover:text-blue-700">Training Notes</p>
                                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['trainingNotes'] }}</p>
                                </div>
                                <span class="text-3xl text-blue-500 group-hover:scale-110 transition-transform">📝</span>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-yellow-50 to-white p-4 rounded-lg shadow border-l-4 border-yellow-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-md font-semibold text-yellow-600 group-hover:text-yellow-700">Messages-received</p>
                                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['messages'] }}</p>
                                </div>
                                <span class="text-3xl text-yellow-500 group-hover:scale-110 transition-transform">✉️</span>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-red-50 to-white p-4 rounded-lg shadow border-l-4 border-red-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-md font-semibold text-red-600 group-hover:text-red-700">Calendar Events</p>
                                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['events'] }}</p>
                                </div>
                                <span class="text-3xl text-red-500 group-hover:scale-110 transition-transform">📅</span>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-purple-50 to-white p-4 rounded-lg shadow border-l-4 border-purple-500 transform hover:scale-105 transition-all hover:shadow-xl group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <p class="text-md font-semibold text-purple-600 group-hover:text-purple-700">Coaches</p>
                                    <p class="text-3xl font-bold text-gray-800 mt-2">{{ $stats['coaches'] ?? 0 }}</p>
                                </div>
                                <span class="text-3xl text-purple-500 group-hover:scale-110 transition-transform">👨‍🏫</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End Quick Stats Section -->

                <!-- Recent Messages Section -->
                <div class="mt-8">
                    <h3 class="text-xl font-bold mb-4">Recent Messages</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="py-3 px-4 text-left">Subject</th>
                                    <th class="py-3 px-4 text-left">Created</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach (\App\Models\Message::where('recipient_id', auth()->id())->orderBy('created_at', 'desc')->take(5)->get() as $message)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $message->subject }}</td>
                                        <td class="py-3 px-4">{{ $message->created_at->format('M d, Y') }}</td>
                                        <td class="py-3 px-4">
                                            <div class="flex items-center gap-2">
                                                <a href="{{ route('messages.show', $message) }}"
                                                    class="text-blue-500 hover:text-blue-700">View</a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                                @if (\App\Models\Message::where('recipient_id', auth()->id())->count() == 0)
                                    <tr>
                                        <td colspan="4" class="py-4 px-4 text-center text-gray-500">No messages found. Check back later!</td>
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
