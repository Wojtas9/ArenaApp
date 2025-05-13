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

            <div class="mt-8 p-4 border border-[#8C508F] rounded-lg">
                <span class="text-xl block mb-2">📤</span>
                <p class="text-sm">Add files</p>
                <p class="text-xs opacity-70">Up to 20 GB</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Message Details</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('messages.reply', $message) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">Reply</a>
                    <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                    </form>
                    <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back</a>
                </div>
            </div>

            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
                <div class="flex justify-between mb-4">
                    <div>
                        <p class="mb-1"><span class="font-semibold">From:</span> {{ $message->sender->name }}</p>
                        <p class="mb-1"><span class="font-semibold">To:</span> {{ $message->recipient->name }}</p>
                        <p class="mb-1"><span class="font-semibold">Subject:</span> {{ $message->subject }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500 dark:text-gray-400">{{ $message->created_at->format('M d, Y h:i A') }}</p>
                    </div>
                </div>
                
                <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                    <p class="whitespace-pre-wrap">{{ $message->content }}</p>
                </div>
            </div>

            @if($message->parent)
            <div class="mt-8">
                <h2 class="text-lg font-semibold mb-4">Original Message</h2>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                    <div class="flex justify-between mb-4">
                        <div>
                            <p class="mb-1"><span class="font-semibold">From:</span> {{ $message->parent->sender->name }}</p>
                            <p class="mb-1"><span class="font-semibold">To:</span> {{ $message->parent->recipient->name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500 dark:text-gray-400">{{ $message->parent->created_at->format('M d, Y h:i A') }}</p>
                        </div>
                    </div>
                    
                    <div class="border-t border-gray-200 dark:border-gray-600 pt-4">
                        <p class="whitespace-pre-wrap">{{ $message->parent->content }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection