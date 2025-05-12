@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
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
@endsection