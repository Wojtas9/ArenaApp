<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management - Admin Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        <div class="w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-2xl shadow-lg">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
                    <span class="text-xl">1</span>
                </div>
                <div>
                    <h3 class="font-semibold">Admin Name</h3>
                    <p class="text-sm opacity-70">2</p>
                </div>
            </div>

            <nav class="space-y-4">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                    <span class="text-xl">3</span>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">4</span>
                    <span>Folders</span>
                </a>
                <a href="{{ route('admin.users') }}" class="flex items-center gap-3 p-3 rounded bg-[#8C508F] transition-colors">
                    <span class="text-xl">👥</span>
                    <span>User Management</span>
                </a>
                <a href="#" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                    <span class="text-xl">5</span>
                    <span>Settings</span>
                </a>
            </nav>

            <div class="mt-8 p-4 border border-[#8C508F] rounded-lg">
                <span class="text-xl block mb-2">6</span>
                <p class="text-sm">Add files</p>
                <p class="text-xs opacity-70">Up to 20 GB</p>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
            <!-- Top Bar -->
            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold">User Management</h1>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Search users..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-200">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2">🔍</span>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg">Logout</button>
                    </form>
                </div>
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
</body>
</html>