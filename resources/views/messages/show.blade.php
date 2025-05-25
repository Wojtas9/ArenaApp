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
        
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
            ],
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
        ])

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