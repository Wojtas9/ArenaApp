@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Add New Sports Hall</h1>
            <a href="{{ route('spots.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to List
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

        <form method="POST" enctype="multipart/form-data" action="{{ route('spots.store') }}">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700 dark:text-gray-300 mb-2">Name</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="location" class="block text-gray-700 dark:text-gray-300 mb-2">Location</label>
                <input type="text" name="location" id="location" value="{{ old('location') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="capacity" class="block text-gray-700 dark:text-gray-300 mb-2">Capacity</label>
                <input type="number" name="capacity" id="capacity" value="{{ old('capacity') }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            </div>
            
            <div class="mb-4">
                <label for="description" class="block text-gray-700 dark:text-gray-300 mb-2">Description</label>
                <textarea name="description" id="description" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description') }}</textarea>
            </div>
            
            <div class="mb-4">
                <label for="picture" class="block text-gray-700 dark:text-gray-300 mb-2">Picture</label>
                <input type="file" name="picture" accept="image/*">
            </div>
            
            <div class="flex justify-end">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                    Save Sports Hall
                </button>
            </div>
        </form>
    </div>
</div>
@endsection