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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Create New Message</h1>
                <div class="flex space-x-2">
                    <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">Back to Messages</a>
                </div>
            </div>

            @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form action="{{ route('messages.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="mb-4">
                    <label for="recipient" class="block text-gray-700 dark:text-gray-300 mb-2">Recipient</label>
                    <select name="recipient_id" id="recipient" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                        <option value="">Select Recipient</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-4">
                    <label for="subject" class="block text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                </div>
                
                <div class="mb-4">
                    <label for="message" class="block text-gray-700 dark:text-gray-300 mb-2">Message</label>
                    <textarea name="message" id="message" rows="6" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>{{ old('message') }}</textarea>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection