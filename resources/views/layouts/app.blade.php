<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased" x-data="{ sidebarOpen: false }">
        <div class="flex h-screen overflow-hidden bg-gray-100">
            
            <!-- SIDEBAR -->
            @include('layouts.sidebar')
            
            <!-- MAIN CONTENT WRAPPER -->
            <div class="flex-1 flex flex-col overflow-hidden">
                
                <!-- NAVIGATION/HEADER dengan TOMBOL HAMBURGER -->
                <header class="bg-white shadow-sm">
                    <div class="flex items-center justify-between px-4 py-3 lg:px-6">
                        
                        <!-- TOMBOL HAMBURGER (hanya muncul di mobile) -->
                        <button @click="sidebarOpen = true" 
                                class="lg:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 hover:text-gray-900 transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                        
                        <!-- HEADER CONTENT (jika ada) -->
                        @if (isset($header))
                            <div class="flex-1">
                                {{ $header }}
                            </div>
                        @else
                            <div class="flex-1 lg:block hidden">
                                <h1 class="text-xl font-semibold text-gray-800">{{ config('app.name', 'RestoApp') }}</h1>
                            </div>
                        @endif
                        
                        <!-- User Dropdown atau Navigation lainnya -->
                        <div class="flex items-center space-x-4">
                            @auth
                                <div class="relative" x-data="{ open: false }">
                                    <button @click="open = !open" class="flex items-center text-sm font-medium text-gray-700 hover:text-gray-900">
                                        <span>{{ Auth::user()->name }}</span>
                                        <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>
                                    
                                    <!-- Dropdown Menu -->
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition:enter="transition ease-out duration-200"
                                         x-transition:enter-start="opacity-0 scale-95"
                                         x-transition:enter-end="opacity-100 scale-100"
                                         x-transition:leave="transition ease-in duration-150"
                                         x-transition:leave-start="opacity-100 scale-100"
                                         x-transition:leave-end="opacity-0 scale-95"
                                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50"
                                         style="display: none;">
                                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                                Log Out
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endauth
                        </div>
                    </div>
                </header>
                
                <!-- CONTENT AREA -->
                <main class="flex-1 overflow-y-auto p-6">
                    {{ $slot }}
                </main>
                
            </div>
        </div>
    </body>
</html>