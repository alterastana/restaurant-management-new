<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restoran Lezat — Find Restaurants & Menus</title>
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <!-- Add Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <!-- Add Alpine.js -->
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <!-- Add Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-pattern {
            background-color: #ffffff;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f3f4f6' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="antialiased">
    <!-- Navigation -->
    <nav class="navbar">
        <div class="navbar-inner">
            <a href="/" class="brand-pill">
                <img src="{{ asset('images/logo.png') }}"  class="logo">
                <span class="brand-text">Restoran Lezat</span>
            </a>
            
            <div class="nav-links">
                <a href="{{ route('landing.restaurants') }}">Restaurants</a>
                <a href="{{ route('landing.restaurants') }}#menus">Menus</a>
                <a href="{{ route('landingpage.menu') }}#reservations">Reservations</a>
                @guest
                    <a href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endguest
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <!-- ensure top padding matches nav height (h-16) so content not hidden under fixed nav -->
    <section class="hero-pattern min-h-screen flex items-center pt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
                <div class="animate__animated animate__fadeInLeft">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 mb-6">
                        Find the Best Restaurants & Menus Near You
                    </h1>
                    <p class="text-lg text-gray-600 mb-8">
                        Explore local restaurants, view complete menus, and easily make orders or reservations. Discover top-rated flavors from our curated selection of dining spots.
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('landing.restaurants') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-brand-primary hover:bg-brand-primary/90 transition">
                            View Restaurants
                        </a>
                        <a href="{{ route('landingpage.menu') }}" class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                            View Menu
                        </a>
                    </div>
                </div>
                <div class="animate__animated animate__fadeInRight">
                    <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1470&q=80" 
                         alt="Restaurant Management" 
                         class="rounded-lg shadow-xl w-full">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section removed per request -->

    <!-- Call to Action -->
    <section class="py-20 bg-brand-primary">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4 animate__animated animate__fadeInUp">
                Ready to Transform Your Restaurant Management?
            </h2>
            <p class="text-lg text-white/90 mb-8 animate__animated animate__fadeInUp" style="animation-delay: 0.2s">
                Join thousands of restaurants already using our platform
            </p>
            <a href="{{ route('register') }}" 
               class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-full text-brand-primary bg-white hover:bg-gray-50 shadow-lg transition transform hover:-translate-y-0.5 animate__animated animate__fadeInUp"
               style="animation-delay: 0.4s; z-index: 20; position: relative;">
                Get Started Now
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-4">Restoran Lezat</h3>
                    <p class="text-gray-400">Empowering restaurants with modern management solutions</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition">About Us</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Privacy Policy</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition">Terms of Service</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-4">Contact Us</h3>
                    <ul class="space-y-2">
                        <li class="text-gray-400">Email: info@restaurant.com</li>
                        <li class="text-gray-400">Phone: (123) 456-7890</li>
                        <li class="text-gray-400">Address: 123 Restaurant St, City</li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Restoran Lezat. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>