<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Arena App') }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Additional styles -->
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            opacity: 0;
            animation: fadeIn 0.5s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
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

    <!-- Page Content -->
    <main>
        @yield('content')
    </main>

    @if(isset($roleStats))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('rolesChart');
            if (ctx) {
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['Admin', 'Coach', 'Player'],
                        datasets: [{
                            data: [{{ $roleStats['admin'] }}, {{ $roleStats['coach'] }}, {{ $roleStats['player'] }}],
                            backgroundColor: ['#CF5B44', '#8C508F', '#0b2558'],
                            borderWidth: 0,
                            cutout: '70%'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                display: false
                            }
                        }
                    }
                });
            }
        });
    </script>
    @endif
</body>
</html>