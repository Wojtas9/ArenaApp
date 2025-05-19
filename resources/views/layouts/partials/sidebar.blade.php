<div class="w-64 bg-[#cf5b44] text-white p-6 rounded-2xl shadow-lg">
    <div class="flex items-center gap-3 mb-8">
        <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
            {{-- Placeholder for dynamic icon based on section or user role --}}
            <span class="text-xl">{{ $sidebarIcon ?? '🚀' }}</span>
        </div>
        <div>
            {{-- Placeholder for dynamic title/name --}}
            <h3 class="font-semibold">{{ $sidebarTitle ?? 'Navigation' }}</h3>
            {{-- Placeholder for dynamic subtitle/role --}}
            <p class="text-sm opacity-70">{{ $sidebarSubtitle ?? 'Menu' }}</p>
        </div>
    </div>

    <nav class="space-y-4">
        @if(Auth::check())
            {{-- Dashboard Link --}}
            <a href="{{ route(auth()->user()->role . '.dashboard') }}"
               class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors {{ request()->routeIs(auth()->user()->role . '.dashboard') ? 'bg-[#0B2558]' : '' }}">
                <span class="text-xl">📊</span>
                <span>{{ ucfirst(auth()->user()->role) }} Dashboard</span>
            </a>

            {{-- Admin Links --}}
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('admin.users') }}"
                   class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors {{ request()->routeIs('admin.users') ? 'bg-[#0B2558]' : '' }}">
                    <span class="text-xl">👥</span>
                    <span>User Management</span>
                </a>
                <a href="{{ route('spots.index') }}"
                   class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors {{ request()->routeIs('spots.index') ? 'bg-[#0B2558]' : '' }}">
                    <span class="text-xl">🏟️</span>
                    <span>Spot Management</span>
                </a>
            @endif

            {{-- Coach Links --}}
            @if(Auth::user()->role == 'coach')
                <a href="{{ route('spots.index') }}"
                   class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors {{ request()->routeIs('spots.index') ? 'bg-[#0B2558]' : '' }}">
                    <span class="text-xl">🏟️</span>
                    <span>Spot Management</span>
                </a>
                {{-- Assuming 'coach.training_sets' is the route name for Training Sets --}}
                <a href="{{ route('coach.training_sets') }}"
                   class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors {{ request()->routeIs('coach.training_sets') ? 'bg-[#0B2558]' : '' }}">
                    <span class="text-xl">🏋️</span>
                    <span>Training Sets</span>
                </a>
            @endif

            {{-- Links for Admin, Coach, and Player --}}
            {{-- Calendar Link --}}
            <a href="{{ route('calendar') }}"
               class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors {{ request()->routeIs('calendar') ? 'bg-[#8C508F]' : '' }}">
                <span class="text-xl">📅</span>
                <span>Calendar</span>
            </a>

            {{-- Messages Link --}}
            <a href="{{ route('messages.index') }}"
               class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors {{ request()->routeIs('messages.index') ? 'bg-[#8C508F]' : '' }}">
                <span class="text-xl">💬</span>
                <span>Messages</span>
            </a>
        @endif
    </nav>

    @if(Auth::check())
        <form method="POST" action="{{ route('logout') }}" class="mt-auto">
            @csrf
            <button type="submit" class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors w-full text-left">
                <span class="text-xl">🚪</span>
                <span>Logout</span>
            </button>
        </form>
    @endif
</div>