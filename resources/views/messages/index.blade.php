@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
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
                @if(auth()->user()->role === 'coach')
                    <a href="{{ route('coach.dashboard') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                        <span class="text-xl">📊</span>
                        <span>Coach Dashboard</span>
                    </a>
                @elseif(auth()->user()->role === 'player')
                    <a href="{{ route('player.dashboard') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                        <span class="text-xl">📊</span>
                        <span>Player Dashboard</span>
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                        <span class="text-xl">📊</span>
                        <span>Admin Dashboard</span>
                    </a>
                @endif
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">👥</span>
                    <span>User Management</span>
                </a>
                
                <a href="{{ route('messages.index') }}" class="flex items-center gap-3 p-3 rounded bg-[#8C508F] transition-colors">
                    <span class="text-xl">📩</span>
                    <span>Messages</span>
                </a>
                <a href="/spots" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">🏟️</span>
                    <span>Spots</span>
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
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('messages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        New Message
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                    </form>
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-6">
                <div class="flex border-b border-gray-200">
                    <button class="px-4 py-2 border-b-2 border-blue-500 text-blue-500 font-medium" id="inbox-tab" data-bs-toggle="tab" data-bs-target="#inbox">Inbox</button>
                    <button class="px-4 py-2 border-b-2 border-transparent hover:text-blue-500 hover:border-blue-500" id="sent-tab" data-bs-toggle="tab" data-bs-target="#sent">Sent Messages</button>
                </div>
            </div>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="inbox">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-4 text-left">From</th>
                                    <th class="py-3 px-4 text-left">Subject</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($receivedMessages as $message)
                                <tr class="border-b border-gray-200 dark:border-gray-700 {{ $message->read_at ? '' : 'bg-blue-50 dark:bg-blue-900' }}">
                                    <td class="py-3 px-4">{{ $message->sender->name }}</td>
                                    <td class="py-3 px-4">{{ $message->subject }}</td>
                                    <td class="py-3 px-4">{{ $message->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('messages.show', $message) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                        <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-3 px-4 text-center">No messages found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="tab-pane fade" id="sent">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white dark:bg-gray-800">
                            <thead>
                                <tr class="bg-gray-100 dark:bg-gray-700">
                                    <th class="py-3 px-4 text-left">To</th>
                                    <th class="py-3 px-4 text-left">Subject</th>
                                    <th class="py-3 px-4 text-left">Date</th>
                                    <th class="py-3 px-4 text-left">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sentMessages as $message)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-3 px-4">{{ $message->recipient->name }}</td>
                                    <td class="py-3 px-4">{{ $message->subject }}</td>
                                    <td class="py-3 px-4">{{ $message->created_at->format('M d, Y h:i A') }}</td>
                                    <td class="py-3 px-4 flex space-x-2">
                                        <a href="{{ route('messages.show', $message) }}" class="text-blue-600 hover:text-blue-800">View</a>
                                        <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-3 px-4 text-center">No sent messages found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection