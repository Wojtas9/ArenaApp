<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arena App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes backgroundZoom {
            from { transform: scale(1); }
            to { transform: scale(1.1); }
        }
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }
        .animate-background {
            animation: backgroundZoom 10s ease-in-out infinite alternate;
        }
    </style>
</head>
<body class="dark:bg-gray-900 transition-colors duration-300 select-none">
    <!-- Flash Messages -->
    @if(session('error'))
    <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="flash-message">
        {{ session('error') }}
    </div>
    <script>
        setTimeout(function() {
            document.getElementById('flash-message').style.display = 'none';
        }, 5000);
    </script>
    @endif
    <!-- Navigation -->
    <nav class="absolute top-0 left-0 right-0 z-50 py-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">

                <div class="text-white text-2xl font-bold" >ArenaApp</div>
                <div>
                    @guest
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-200 mr-4 transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="bg-[#EAAD59] hover:bg-[#ffc153] text-[#232325] px-4 py-2 rounded-lg transition-colors">Register</a>

                    @else
                        <div class="flex items-center">
                            <span class="text-white mr-4">Welcome, {{ auth()->user()->name }}</span>
                            <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isCoach() ? route('coach.dashboard') : route('player.dashboard')) }}" 
                               class="text-white hover:text-blue-200 mr-4 transition-colors">Dashboard</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">Logout</button>
                            </form>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
    <!-- Hero Section -->
    <section class="relative h-screen flex items-center">
        <video autoplay muted loop playsinline class="absolute inset-0 w-full h-full object-cover">
            <source src="/movies/hero_animation.mp4" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Manage Your Sports Venues</h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">The ultimate platform for booking, managing, and optimizing your sports facilities</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @guest
                    <a href="{{ route('login') }}" class="bg-[#232325] hover:bg-[#ffc153] text-white px-4 py-2 rounded-lg transition-colors">Login</a>
                    <a href="{{ route('register') }}" class="bg-[#EAAD59] hover:bg-[#ffc153] text-[#232325] px-4 py-2 rounded-lg transition-colors">Register</a>
                @else
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isCoach() ? route('coach.dashboard') : route('player.dashboard')) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-medium transition-all duration-300 transform hover:scale-105">Go to Dashboard</a>
                @endguest
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-20 bg-[#232325] dark:bg-gray-800">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <!-- Feature Card 1 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900 rounded-lg flex items-center justify-center mb-6">
                        🔥
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Real-time Updates</h3>
                    <p class="text-gray-600 dark:text-gray-400">Instant notifications and live tracking for all your events.</p>
                </div>
                
                <!-- Feature Card 2 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900 rounded-lg flex items-center justify-center mb-6">
                        📅
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Smart Scheduling</h3>
                    <p class="text-gray-600 dark:text-gray-400">AI-powered calendar management and conflict resolution.</p>
                </div>

                <!-- Feature Card 3 -->
                <div class="bg-white dark:bg-gray-900 p-8 rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300">
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900 rounded-lg flex items-center justify-center mb-6">
                        🤝
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Collaboration</h3>
                    <p class="text-gray-600 dark:text-gray-400">Team management tools with role-based access control.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="bg-gradient-to-r from-[#ffcc52] to-[#EAAD59] text-white py-20">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of event organizers already using Arena</p>
            @guest
                <a href="{{ route('register') }}" class="bg-[#232325] text-white shadow-xl/20 px-8 py-2 rounded-lg text-lg font-medium transition-all duration-300 transform  inline-block">
                    Create Free Account
           
                </a>
            @else
                <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : (auth()->user()->isCoach() ? route('coach.dashboard') : route('player.dashboard')) }}" class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105 inline-block">
                    Go to Dashboard
                </a>
            @endguest
        </div>
    </section>
</body>
</html>