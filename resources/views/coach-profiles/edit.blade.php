@extends('layouts.app')

@section('content')
    <div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden min-h-screen">
        <!-- Video Background -->
        <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0"
            style="min-width:100vw;min-height:100vh;">
            <source src="/movies/hero_animation.mp4" type="video/mp4">
        </video>
        <div class="fixed inset-0 bg-black/50 z-10"></div>
        <div class="flex flex-col md:flex-row max-w-[1400px] mx-auto gap-6 relative z-20">
            <!-- Sidebar -->
            @include('layouts.partials.sidebar', [
                'sidebarIcon' => '👨‍🏫',
                'sidebarTitle' => Auth::user()->name,
                'sidebarSubtitle' => ucfirst(Auth::user()->role),
                'navLinks' => [
                    ['icon' => '📊', 'text' => 'Dashboard', 'href' => route('coach.dashboard'), 'active_check_route_name' => 'coach.dashboard'],
                    ['icon' => '👤', 'text' => 'My Profile', 'href' => route('coach-profiles.show', auth()->id()), 'active_check_route_name' => 'coach-profiles.show'],
                    ['icon' => '📩', 'text' => 'Messages', 'href' => route('messages.index'), 'active_check_route_name' => 'messages.index'],
                    ['icon' => '🏟️', 'text' => 'Sports Halls', 'href' => route('spots.index'), 'active_check_route_name' => 'spots.index'],
                    ['icon' => '📚', 'text' => 'Training Programs', 'href' => route('training-programs.index'), 'active_check_route_name' => 'training-programs.index']
                ]
            ])

            <!-- Main Content -->
            <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">{{ isset($coachProfile) ? 'Edit' : 'Create' }} Coach Profile</h1>

                </div>

                <!-- Form -->
                <form action="{{ route('coach-profiles.update', $coachProfile->user_id ?? auth()->id()) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <!-- Remove @method('PUT') directive -->

                    <!-- Profile Image -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Profile Image</h3>
                        <div class="flex items-center gap-6">
                            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200">
                                @if (isset($coachProfile) && $coachProfile->photo)
                                    <img id="profile-preview" src="{{ asset('storage/' . $coachProfile->photo) }}"
                                        alt="Profile Preview" class="w-full h-full object-cover">
                                @else
                                    <div id="profile-preview"
                                        class="w-full h-full bg-[#8C508F] flex items-center justify-center text-white text-3xl">
                                        {{ substr(auth()->user()->name, 0, 1) }}
                                    </div>
                                @endif
                            </div>
                            <div>
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Upload New
                                    Image</label>
                                <div class="relative">
                                    <input type="file" name="photo" id="photo" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" lang="en">
                                    <div
                                        class="bg-[#8C508F] text-white px-4 py-2 rounded-full inline-flex items-center gap-2 hover:bg-[#734072] transition-colors">
                                        <span>Choose File</span>
                                    </div>
                                    <span class="ml-3 text-sm text-gray-500" id="file-name">No file chosen</span>
                                </div>
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <script>
                                document.getElementById('photo').addEventListener('change', function(e) {
                                    const fileName = e.target.files[0]?.name || 'No file chosen';
                                    document.getElementById('file-name').textContent = fileName;
                                });
                            </script>
                        </div>
                    </div>

                    <!-- About Me -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">About Me</h3>
                        <div class="text-sm text-gray-500 mt-1">
                            Previous bio: {{ $coachProfile->description ?? 'No previous bio found' }}
                        </div>
                    </div>

                    <!-- Specializations -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Specializations</h3>
                        <div>
                            <label for="specialty" class="block text-sm font-medium text-gray-700 mb-2">Specializations
                                (comma
                                separated)</label>
                            <input type="text" name="specialty" id="specialty"
                                value="{{ old('specialty', $coachProfile->specialty ?? '') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50"
                                placeholder="e.g. Basketball, Fitness Training, Youth Coaching">
                            @error('specialty')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Favorite Halls -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Favorite Halls</h3>
                        <div>
                            <label for="favorite_halls" class="block text-sm font-medium text-gray-700 mb-2">Favorite Sports
                                Halls</label>
                            <select name="favorite_halls" id="favorite_halls" multiple
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50 h-32 overflow-y-auto"
                                onchange="updateFavoriteHalls(this)">
                                @foreach ($spots as $spot)
                                    <option value="{{ $spot->name }}"
                                        {{ in_array($spot->name, explode(',', $coachProfile->favorite_halls ?? '')) ? 'selected' : '' }}>
                                        {{ $spot->name }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="favorite_halls" id="favorite_halls_input"
                                value="{{ old('favorite_halls', $coachProfile->favorite_halls ?? '') }}">
                            <p class="mt-2 text-sm text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple
                                halls</p>
                            @error('favorite_halls')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <!-- Accessibility -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Accessibility</h3>
                        <div>
                            <label for="accessibility" class="block text-sm font-medium text-gray-700 mb-2">Availability &
                                Accessibility</label>
                            <textarea name="accessibility" id="accessibility" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50"
                                placeholder="Describe your availability and accessibility...">{{ old('accessibility', $coachProfile->accessibility ?? '') }}</textarea>
                            @error('accessibility')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <!-- Add Save Button -->
                    <div class="mt-6">
                        <button type="submit"
                            class="w-full bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-lg transition-colors">
                            Save Changes
                        </button>
                    </div>
            </div>

          
            </form>
        </div>
    </div>
    </div>

    <script>
        // Preview uploaded image
        document.getElementById('profile_image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('profile-preview');
                    preview.innerHTML = '';
                    preview.style.backgroundColor = '';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';
                    preview.appendChild(img);
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
    <script>
        function updateFavoriteHalls(selectElement) {
            const selectedOptions = Array.from(selectElement.selectedOptions).map(option => option.value);
            document.getElementById('favorite_halls_input').value = selectedOptions.join(',');
        }
    </script>
@endsection
