<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <!-- Sidebar -->
        <div class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-lg">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-brand-primary">
                <h1 class="text-xl font-bold text-white">{{ config('app.name') }}</h1>
            </div>

            <!-- Navigation -->
            <nav class="p-4">
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('dashboard')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('Dashboard.loyalty.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.loyalty.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-12v4m-2-2h4m5 4v4m-2-2h4M17 3l-1.172 1.172a4 4 0 00-5.656 0L10 3m4 4l-1.172-1.172a4 4 0 00-5.656 0L6 7"></path></svg>
                            <span>Loyalty</span>
                        </a>
                    </li>

                    @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
                    <li>
                        <a href="{{ route('Dashboard.restoran.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.restoran.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            <span>Restoran</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('Dashboard.menu.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.menu.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                            <span>Menu</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('Dashboard.table.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.table.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                            <span>Table</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('Dashboard.customer.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.customer.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            <span>Customer</span>
                        </a>
                    </li>
                    @endif

                    @if(Auth::user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('Dashboard.manager.index') }}" class="flex items-center px-4 py-2.5 rounded-lg font-medium transition duration-200 @if(request()->routeIs('Dashboard.manager.*')) bg-brand-primary text-white @else sidebar-link hover:bg-gray-100 @endif">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>Manager</span>
                        </a>
                    </li>
                    @endif
                </ul>
            </nav>

            <!-- Logout Button -->
            <div class="absolute bottom-0 left-0 right-0 p-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full btn-secondary rounded-lg">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Main Content -->
        <div class="ml-64">
            <!-- Header -->
            <header class="bg-white shadow">
                <div class="px-6 py-4">
                    @hasSection('header')
                        @yield('header')
                    @else
                        <h1 class="text-xl font-semibold text-gray-800">Dashboard</h1>
                    @endif
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-6">
                @hasSection('dashboard-content')
                    @yield('dashboard-content')
                @elseif (View::hasSection('content'))
                    @yield('content')
                @endif
            </main>
        </div>
    </div>
</body>
</html>