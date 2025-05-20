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
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Messages</h1>
                <div class="flex space-x-3">
                    <a href="{{ route('messages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                        New Message
                    </a>
                    
                </div>
            </div>

            @if (session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                    {{ session('success') }}
                </div>
            @endif
                <!-- Tabs -->
                <div class="mb-4 border-b border-gray-200">
                    <ul class="flex flex-wrap -mb-px text-sm font-medium text-center">
                        <li class="mr-2">
                            <a href="#" id="inbox-tab" class="inline-block p-4 border-b-2 border-blue-500 rounded-t-lg active" 
                               onclick="showTab('inbox'); return false;">Inbox</a>
                        </li>
                        <li class="mr-2">
                            <a href="#" id="sent-tab" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:border-gray-300"
                               onclick="showTab('sent'); return false;">Sent Messages</a>
                        </li>
                    </ul>
                </div>
                
                <!-- Inbox Tab Content -->
                <div id="inbox-content" class="tab-content">
                    <h2 class="text-xl font-semibold mb-4">Received Messages</h2>
                    
                    @if($receivedMessages->isEmpty())
                        <p class="text-gray-500">No messages received.</p>
                    @else
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">From</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($receivedMessages as $message)
                                        <tr class="{{ $message->read ? '' : 'font-bold bg-blue-50' }}">
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->sender->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('messages.show', $message) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                
                <!-- Sent Tab Content -->
                <div id="sent-content" class="tab-content hidden">
                    <h2 class="text-xl font-semibold mb-4">Sent Messages</h2>
                    
                    @if($sentMessages->isEmpty())
                        <p class="text-gray-500">No messages sent.</p>
                    @else
                        <div class="bg-white shadow-md rounded-lg overflow-hidden">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">To</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subject</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($sentMessages as $message)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->recipient->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->subject }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $message->created_at->format('M d, Y H:i') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                <a href="{{ route('messages.show', $message) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                                <form action="{{ route('messages.destroy', $message) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this message?')">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
                
                <!-- JavaScript for tab switching -->
                <script>
                    function showTab(tabName) {
                        // Hide all tab contents
                        document.querySelectorAll('.tab-content').forEach(tab => {
                            tab.classList.add('hidden');
                        });
                        
                        // Remove active class from all tabs
                        document.querySelectorAll('a[id$="-tab"]').forEach(tab => {
                            tab.classList.remove('active', 'border-blue-500');
                            tab.classList.add('border-transparent');
                        });
                        
                        // Show the selected tab content
                        document.getElementById(tabName + '-content').classList.remove('hidden');
                        
                        // Add active class to the clicked tab
                        const activeTab = document.getElementById(tabName + '-tab');
                        activeTab.classList.add('active', 'border-blue-500');
                        activeTab.classList.remove('border-transparent');
                    }
                </script>
            </div>
        </div>
    </div>
</div>
@endsection