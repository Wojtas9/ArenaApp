@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">New Message</h1>
            <a href="{{ route('messages.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to Messages
            </a>
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
            <div class="mb-4">
                <label for="recipient_id" class="block text-gray-700 dark:text-gray-300 mb-2">Recipient</label>
                <select name="recipient_id" id="recipient_id" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('recipient_id') border-red-500 @enderror" required>
                    <option value="">Select Recipient</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ old('recipient_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->name }} ({{ $user->email }})
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="mb-4">
                <label for="subject" class="block text-gray-700 dark:text-gray-300 mb-2">Subject</label>
                <input type="text" name="subject" id="subject" value="{{ old('subject') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('subject') border-red-500 @enderror" required>
            </div>
            
            <div class="mb-4">
                <label for="content" class="block text-gray-700 dark:text-gray-300 mb-2">Message</label>
                <textarea name="content" id="content" rows="6" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" required>{{ old('content') }}</textarea>
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Send Message
                </button>
            </div>
        </form>
    </div>
</div>
@endsection