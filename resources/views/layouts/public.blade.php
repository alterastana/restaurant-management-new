<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .site-main {
            flex: 1;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="navbar">
        <div class="container navbar-inner">
            <div class="brand">
                <a href="/" class="brand-pill">
                    <img src="{{ asset('images/logo.svg') }}" alt="Restaurant Lezat" class="logo">
                    <span class="brand-text name-hide-mobile">Restaurant Lezat</span>
                </a>
            </div>
            <!-- <div class="nav-links">
                <a href="{{ route('landing.restaurants') }}">Restaurants</a>
                <a href="{{ route('landing.restaurants') }}#menus">Menus</a>

                @auth
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                @else
                    <a href="{{ route('login') }}">Login</a>
                    @if(Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </div> -->
        </div>
    </nav>

    <main class="site-main">
        @yield('content')
    </main>

    <footer>
        <div class="container">
            <p style="text-align:center;">&copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>