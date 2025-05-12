@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Reply to Message</h1>
            <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to Messages
            </a>
        </div>

        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 mb-6">
            <h2 class="text-lg font-semibold mb-4">Original Message</h2>
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

        @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('messages.store') }}">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $message->id }}">
            <input type="hidden" name="recipient_id" value="{{ $message->sender_id }}">
            <input type="hidden" name="subject" value="RE: {{ $message->subject }}">
            
            <div class="mb-4">
                <label for="content" class="block text-gray-700 dark:text-gray-300 mb-2">Your Reply</label>
                <textarea name="content" id="content" rows="6" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Send Reply
                </button>
            </div>
        </form>
    </div>
</div>
@endsection