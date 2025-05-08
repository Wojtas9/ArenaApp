<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Arena App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes backgroundZoom {
            from { transform: scale(1); }
            to { transform: scale(1.05); }
        }
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 1s ease-out forwards;
        }
        .animate-background {
            animation: backgroundZoom 20s ease-in-out infinite alternate;
        }
    </style>
</head>
<body class="dark:bg-gray-900 transition-colors duration-300">
    <!-- Hero Section -->
    <section class="relative bg-cover bg-center h-screen flex items-center animate-background" style="background-image: url('/images/bg_banner.jpg')">
        <div class="absolute inset-0 bg-black/50"></div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-white z-10">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6">Manage Your Sports Venues</h1>
            <p class="text-xl md:text-2xl mb-10 max-w-3xl mx-auto">The ultimate platform for booking, managing, and optimizing your sports facilities</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-lg text-lg font-medium transition-all duration-300 transform hover:scale-105">Get Started</a>
                <a href="#" class="bg-transparent border-2 border-white hover:bg-white hover:text-blue-600 text-white px-8 py-4 rounded-lg text-lg font-medium transition-all duration-300 transform hover:scale-105">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Features Grid -->
    <section class="py-20 bg-gray-50 dark:bg-gray-800">
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
    <section class="bg-gradient-to-r from-blue-600 to-purple-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-6">Ready to Get Started?</h2>
            <p class="text-xl mb-8 opacity-90">Join thousands of event organizers already using Arena</p>
            <button class="bg-white text-blue-600 px-8 py-4 rounded-lg text-lg font-medium hover:bg-opacity-90 transition-all duration-300 transform hover:scale-105">
                Create Free Account
            </button>
        </div>
    </section>
</body>
</html>