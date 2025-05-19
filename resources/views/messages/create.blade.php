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
                ['icon' => '👥', 'text' => 'User Management', 'href' => route('admin.users'), 'active_check_route_name' => 'admin.users'],
                ['icon' => '🏟️', 'text' => 'Spots Management', 'href' => route('spots.index'), 'active_check_route_name' => 'spots.index'],
                ['icon' => '⚙️', 'text' => 'Settings', 'href' => '#', 'active_check_route_name' => 'admin.settings'] // Assuming a route name like admin.settings
            ],
            // 'additionalLinks' => [] // Add if there are specific additional links for admin not covered by navLinks
        ])

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