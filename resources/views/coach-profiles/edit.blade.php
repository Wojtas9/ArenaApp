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
            <div
                class="w-full md:w-64 bg-[#cf5b44] text-white border-1 border-solid border-[#232325] p-6 rounded-4xl shadow-lg drop-shadow-xl/50 flex-shrink-0">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-12 h-12 rounded-full bg-[#8C508F] flex items-center justify-center">
                        <span class="text-xl">👨‍🏫</span>
                    </div>
                    <div>
                        <h3 class="font-semibold">{{ auth()->user()->name }}</h3>
                        <p class="text-sm opacity-70">Coach</p>
                    </div>
                </div>

                <nav class="space-y-4">
                    <a href="{{ route('coach.dashboard') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#0B2558] transition-colors">
                        <span class="text-xl">📊</span>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('messages.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">📩</span>
                        <span>Messages</span>
                    </a>
                    <a href="{{ route('spots.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">🏟️</span>
                        <span>Spots</span>
                    </a>
                    <a href="{{ route('training-programs.index') }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">📚</span>
                        <span>Training Programs</span>
                    </a>
                    <a href="{{ route('coach-profiles.show', ['id' => auth()->id()]) }}"
                        class="flex items-center gap-3 p-3 rounded hover:bg-[#8C508F] transition-colors">
                        <span class="text-xl">👤</span>
                        <span>My Profile</span>
                    </a>
                </nav>

                <div class="mt-8">
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit"
                            class="w-full bg-[#8C508F] hover:bg-[#734072] text-white px-4 py-2 rounded-lg transition-colors flex items-center justify-center gap-2">
                            <span class="text-xl">🚪</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 p-8 bg-white rounded-2xl shadow-lg">
                <!-- Top Bar -->
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-2xl font-bold">{{ isset($coachProfile) ? 'Edit' : 'Create' }} Coach Profile</h1>
                   
                </div>

                <!-- Form -->
                <form action="{{ route('coach-profiles.update', $coachProfile->user_id ?? auth()->id()) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-6">
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
                                <label for="photo" class="block text-sm font-medium text-gray-700 mb-2">Upload New Image</label>
                                <input type="file" name="photo" id="photo"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#8C508F] file:text-white hover:file:bg-[#734072]">
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- About Me -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">About Me</h3>
                        <div>
                            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Bio</label>
                            <textarea name="description" id="description" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50"
                                placeholder="Tell us about yourself...">{{ old('description', $coachProfile->description ?? '') }}</textarea>
                            @error('description')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Specializations -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Specializations</h3>
                        <div>
                            <label for="specialty"
                                class="block text-sm font-medium text-gray-700 mb-2">Specializations (comma
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
                            <label for="favorite_halls" class="block text-sm font-medium text-gray-700 mb-2">Favorite Sports Halls</label>
                            <textarea name="favorite_halls" id="favorite_halls" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50"
                                placeholder="List your favorite sports halls...">{{ old('favorite_halls', $coachProfile->favorite_halls ?? '') }}</textarea>
                            @error('favorite_halls')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Accessibility -->
                    <div class="bg-gray-50 p-6 rounded-xl shadow-sm">
                        <h3 class="font-semibold text-lg mb-4">Accessibility</h3>
                        <div>
                            <label for="accessibility" class="block text-sm font-medium text-gray-700 mb-2">Availability & Accessibility</label>
                            <textarea name="accessibility" id="accessibility" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-[#8C508F] focus:ring focus:ring-[#8C508F] focus:ring-opacity-50"
                                placeholder="Describe your availability and accessibility...">{{ old('accessibility', $coachProfile->accessibility ?? '') }}</textarea>
                            @error('accessibility')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>


                    <!-- Submit Button -->
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-[#8C508F] hover:bg-[#734072] text-white px-6 py-3 rounded-lg transition-colors flex items-center gap-2">
                            <span class="text-xl">💾</span>
                            <span>{{ isset($coachProfile) ? 'Update' : 'Create' }} Profile</span>
                        </button>
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
@endsection
