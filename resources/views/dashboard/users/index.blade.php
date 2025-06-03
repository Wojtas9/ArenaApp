@extends('layouts.app')

@section('content')
<div class="flex mb-30 h-240 max-w-[1400px] mx-auto gap-6 relative z-20">
    <!-- Sidebar -->
    @include('layouts.partials.sidebar', [
        'sidebarIcon' => '👨‍💼',
        'sidebarTitle' => Auth::user()->name,
        'sidebarSubtitle' => ucfirst(Auth::user()->role),
        'navLinks' => [
            ['icon' => '📊', 'text' => 'Dashboard', 'href' => route('admin.dashboard'), 'active_check_route_name' => 'admin.dashboard'],
            ['icon' => '👥', 'text' => 'User Management', 'href' => route('admin.users'), 'active_check_route_name' => 'admin.users'],            ]
    ])

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
        <!-- Top Bar -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-2xl font-bold">User Management</h1>
            <div class="flex items-center gap-4">
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Search users..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-200">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Logout</button>
                </form>
            </div>
        </div>
        
        <!-- Rest of your content -->
        <div class="flex gap-3 mb-6">
            <button id="show-all" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg filter-btn active">Show All</button>
            <button id="show-admins" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg filter-btn">Show Admins</button>
            <button id="show-coachs" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg filter-btn">Show Coaches</button>
            <button id="show-players" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg filter-btn">Show Players</button>
        </div>

            <!-- Flash Messages -->
            @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                <p>{{ session('success') }}</p>
            </div>
            @endif

            @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                <p>{{ session('error') }}</p>
            </div>
            @endif

            <!-- Users Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-500">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : ($user->role === 'coach' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                    {{ ucfirst($user->role) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $user->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $user->is_blocked ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                    {{ $user->is_blocked ? 'Blocked' : 'Active' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.toggle-block', $user->id) }}" method="POST" class="inline mr-3">
                                    @csrf
                                    <button type="submit" class="{{ $user->is_blocked ? 'text-green-600 hover:text-green-900' : 'text-yellow-600 hover:text-yellow-900' }}">
                                        {{ $user->is_blocked ? 'Unblock' : 'Block' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this user?')">Delete</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>
    <!-- Filter Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('tbody tr');
            
            function filterTable() {
                const searchTerm = searchInput.value.toLowerCase();
                const activeRole = document.querySelector('.filter-btn.active').id.replace('show-', '');
                
                rows.forEach(row => {
                    const name = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                    const email = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                    const roleCell = row.querySelector('td:nth-child(3) span');
                    const roleText = roleCell.textContent.trim().toLowerCase();
                    
                    let filterRole = activeRole === 'all' ? 'all' : activeRole;
                    if (filterRole !== 'all' && filterRole.endsWith('s')) {
                        filterRole = filterRole.slice(0, -1);
                    }
                    if (filterRole !== 'all') {
                        filterRole = filterRole.toLowerCase();
                    }
                    
                    const matchesSearch = name.includes(searchTerm) || email.includes(searchTerm);
                    const matchesRole = filterRole === 'all' || roleText === filterRole || 
                        (filterRole === 'coach' && roleText.includes('coach'));
                    
                    row.style.display = matchesSearch && matchesRole ? '' : 'none';
                });
            }
            
            // Add event listeners
            searchInput.addEventListener('input', filterTable);
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    filterTable();
                });
            });
        });
    </script>
</body>
</html>
