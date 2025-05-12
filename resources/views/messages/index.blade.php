@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h1>
            <a href="{{ route('messages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                New Message
            </a>
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
@endsection