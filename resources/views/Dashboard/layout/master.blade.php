<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Resto App</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div x-data="{ sidebarOpen: false }" class="flex h-screen bg-gray-100">

        {{-- Sidebar --}}
        @include('Dashboard.layout.sidebar')

        {{-- Konten utama --}}
        <div class="flex flex-col flex-1 overflow-hidden">
            
            {{-- Header --}}
            <header class="flex items-center justify-between px-6 py-4 bg-indigo-600 text-white">
                {{-- Hamburger untuk mobile --}}
                <button @click="sidebarOpen = !sidebarOpen" class="text-white focus:outline-none lg:hidden">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>

                {{-- User menu --}}
                <div class="flex items-center">
                    <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open" class="inline-flex items-center">
                            <span class="mr-2 font-semibold">{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div x-show="open" class="absolute right-0 w-48 mt-2 py-2 bg-white rounded-md shadow-xl z-20" style="display: none;">
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-600 hover:text-white" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</a>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Main content --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto">
                <div class="container mx-auto px-6 py-8">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
