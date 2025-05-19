@extends('layouts.app')

@section('content')
<div class="bg-[#ebebeb] mt-25 p-6 relative overflow-hidden">
    <!-- Video Background -->
    <video autoplay muted loop playsinline class="fixed inset-0 w-full h-full object-cover z-0" style="min-width:100vw;min-height:100vh;">
        <source src="/movies/hero_animation.mp4" type="video/mp4">
    </video>
    <div class="fixed inset-0 bg-black/50 z-10"></div>
    <div class="flex h-270 max-w-[1400px] mx-auto gap-6 relative z-20">
        


    @include('layouts.partials.sidebar', [
            'sidebarIcon' => '👨‍💼',
            'sidebarTitle' => Auth::user()->name,
            'sidebarSubtitle' => ucfirst(Auth::user()->role),
            'navLinks' => [
                ['icon' => '👥', 'text' => 'User Management', 'href' => route('admin.users'), 'active_check_route_name' => 'admin.users'],
                ['icon' => '🏟️', 'text' => 'Spots Management', 'href' => route('spots.index'), 'active_check_route_name' => 'spots.index'],
                ['icon' => '⚙️', 'text' => 'Settings', 'href' => '#', 'active_check_route_name' => 'admin.settings'] // Assuming a route name like admin.settings
            ],
        ])

        <!-- Main Content -->
        <div class="flex-1 p-8 bg-white rounded-4xl shadow-lg drop-shadow-xl/50">
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
                    <label for="picture" class="block text-gray-700 dark:text-gray-300 mb-2">Upload Picture</label>
                    <div class="upload-container relative">
                        <div class="drop-zone p-3 border-2 border-dashed rounded-lg text-center bg-gray-50 mb-2" 
                             id="dropZone" ondrop="handleDrop(event)" ondragover="handleDragOver(event)">
                            <i class="fas fa-cloud-upload-alt text-2xl text-gray-400 mb-2"></i>
                            <p class="text-sm mb-2">Drop image here or</p>
                            <div class="relative">
                                <input type="file" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" 
                                       id="picture" name="picture" accept="image/*" onchange="previewImage(this);">
                                <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded-lg text-sm">
                                    Choose File
                                </button>
                            </div>
                        </div>
                        <div id="imagePreview" class="hidden mt-2">
                            <div class="relative inline-block">
                                <img src="#" alt="Preview" class="rounded-lg" style="max-width: 200px;">
                                <button type="button" class="absolute top-1 right-1 bg-red-500 hover:bg-red-600 text-white rounded-full p-1" 
                                        onclick="removeImage()">
                                    <i class="fas fa-times text-xs"></i>
                                </button>
                            </div>
                        </div>
                        <small class="text-gray-500 text-xs mt-1 block">
                            <i class="fas fa-info-circle"></i> 
                            Supported: JPG, PNG, GIF (max: 5MB)
                        </small>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                        Save Sports Hall
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

<!-- Add this in your head section or before closing body tag -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

<style>
.drop-zone {
    border: 2px dashed #dee2e6;
    transition: all 0.3s ease;
    cursor: pointer;
}

.drop-zone:hover, .drop-zone.dragover {
    border-color: #0d6efd;
    background-color: rgba(13, 110, 253, 0.05);
}

.upload-container input[type="file"] {
    cursor: pointer;
    z-index: 2;
}

.upload-container button {
    z-index: 1;
}
</style>

<script>
function previewImage(input) {
    const preview = document.querySelector('#imagePreview img');
    const previewDiv = document.getElementById('imagePreview');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.classList.remove('hidden'); // Changed from 'd-none' to 'hidden'
        }
        
        reader.readAsDataURL(input.files[0]);
    } else {
        removeImage();
    }
}

function removeImage() {
    const preview = document.querySelector('#imagePreview img');
    const previewDiv = document.getElementById('imagePreview');
    const fileInput = document.getElementById('picture');
    
    preview.src = '';
    previewDiv.classList.add('hidden'); // Changed from 'd-none' to 'hidden'
    fileInput.value = '';
}

function handleDrop(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const dt = e.dataTransfer;
    const files = dt.files;
    
    document.getElementById('picture').files = files;
    previewImage(document.getElementById('picture'));
    document.getElementById('dropZone').classList.remove('dragover');
}

function handleDragOver(e) {
    e.preventDefault();
    e.stopPropagation();
    document.getElementById('dropZone').classList.add('dragover');
}

document.getElementById('dropZone').addEventListener('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    this.classList.remove('dragover');
});
</script>