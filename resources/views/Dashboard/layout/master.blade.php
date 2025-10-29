@extends('layouts.dashboard')

@section('header')
    <div class="flex items-center justify-between px-6 py-4">
        {{-- Hamburger untuk mobile --}}
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-700 focus:outline-none lg:hidden">
            <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        {{-- Optional user menu removed for consistency (sidebar has logout) --}}
    </div>
@endsection

@section('dashboard-content')
    <div class="container mx-auto px-6 py-8 animate-fade-in">
        @yield('content')
    </div>
@endsection
