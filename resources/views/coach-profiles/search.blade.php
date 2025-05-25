@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
        <!-- Sidebar -->
        @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍🏫',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '🍎', 'text' => 'My Diet', 'href' => route('diet.index'), 'active_check_route_name' => 'diet.index'],
            ]
        ])


<!-- Main Content -->
<div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
    <!-- Top Bar -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-bold">Find a Coach</h1>
        <div class="flex items-center gap-4">
            <div class="relative">
                <input type="text" id="coach-search" placeholder="Search coaches..." class="pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#8C508F]">
                <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
            </div>
        </div>
    </div>

    <!-- Coaches Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="coaches-container">
        @foreach($coaches as $coach)
        <div class="coach-card bg-gray-50 rounded-xl shadow-sm overflow-hidden hover:shadow-md transition-shadow" data-coach-name="{{ strtolower($coach->name) }}">
            <div class="p-6">
                <div class="flex flex-col items-center mb-4">
                    @if ($coach->coachProfile && $coach->coachProfile->photo)
                        <img src="{{ asset('storage/' . $coach->coachProfile->photo) }}?v={{ time() }}"
                            alt="{{ $coach->name }}" class="w-24 h-24 object-cover rounded-full mb-3">
                    @else
                        <div class="w-24 h-24 rounded-full bg-[#8C508F] flex items-center justify-center text-white text-3xl mb-3">
                            {{ substr($coach->name, 0, 1) }}
                        </div>
                    @endif
                    <h3 class="text-lg font-semibold">{{ $coach->name }}</h3>
                </div>
                
                <div class="space-y-3">
                    @if($coach->coachProfile->specialty)
                    <div>
                        <span class="font-medium">Specialty:</span>
                        <p>{{ $coach->coachProfile->specialty }}</p>
                    </div>
                    @endif
                    
                    @if($coach->coachProfile->description)
                    <div>
                        <span class="font-medium">About:</span>
                        <p class="text-sm text-gray-600 line-clamp-3">{{ $coach->coachProfile->description }}</p>
                    </div>
                    @endif
                    
                    @if($coach->coachProfile->favorite_halls)
                    <div>
                        <span class="font-medium">Favorite Halls:</span>
                        <p class="text-sm">{{ $coach->coachProfile->favorite_halls }}</p>
                    </div>
                    @endif
                    
                    @if($coach->coachProfile->accessibility)
                    <div>
                        <span class="font-medium">Availability:</span>
                        <p class="text-sm">{{ $coach->coachProfile->accessibility }}</p>
                    </div>
                    @endif
                </div>
                
                <div class="mt-4 flex justify-between items-center">
                    <a href="{{ route('coach-profiles.show', $coach->id) }}" class="text-[#8C508F] hover:underline">View Profile</a>
                    <a href="{{ route('messages.create', ['recipient_id' => $coach->id]) }}" class="bg-[#8C508F] hover:bg-[#734072] text-white px-3 py-1.5 rounded-lg text-sm transition-colors">
                        Message Coach
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- No Results Message -->
    <div id="no-results" class="hidden text-center py-8">
        <p class="text-lg text-gray-500">No coaches found matching your search.</p>
    </div>
</div>

@endsection
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('coach-search');
        const coachCards = document.querySelectorAll('.coach-card');
        const coachesContainer = document.getElementById('coaches-container');
        const noResults = document.getElementById('no-results');
        
        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().trim();
            let visibleCount = 0;
            
            coachCards.forEach(card => {
                const coachName = card.dataset.coachName;
                const isVisible = coachName.includes(searchTerm);
                
                card.style.display = isVisible ? 'block' : 'none';
                if (isVisible) visibleCount++;
            });
            
            if (visibleCount === 0) {
                noResults.classList.remove('hidden');
            } else {
                noResults.classList.add('hidden');
            }
        });
    });
</script>
@endpush
