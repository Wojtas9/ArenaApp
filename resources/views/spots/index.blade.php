@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Sports Halls</h1>
            <a href="{{ route('spots.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Add New Sports Hall
            </a>
        </div>

        @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white dark:bg-gray-800">
                <thead>
                    <tr class="bg-gray-100 dark:bg-gray-700">
                        <th class="py-3 px-4 text-left">Picture</th>
                        <th class="py-3 px-4 text-left">Name</th>
                        <th class="py-3 px-4 text-left">Location</th>
                        <th class="py-3 px-4 text-left">Capacity</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($spots as $spot)
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <td class="py-3 px-4">
                            @if($spot->picture)
                                <img src="{{ asset($spot->picture) }}" alt="Spot Picture" class="h-16 w-16 object-cover rounded">
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="py-3 px-4">{{ $spot->name }}</td>
                        <td class="py-3 px-4">{{ $spot->location }}</td>
                        <td class="py-3 px-4">{{ $spot->capacity }}</td>
                        <td class="py-3 px-4 flex space-x-2">
                            <a href="{{ route('spots.edit', $spot) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('spots.destroy', $spot) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure you want to delete this sports hall?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-3 px-4 text-center">No sports halls found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection