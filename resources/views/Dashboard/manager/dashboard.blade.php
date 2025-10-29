@extends('Dashboard.layout.master')

@section('title', 'Dashboard')

@section('content')
    {{-- Bagian Header dengan Sapaan Personal --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang Kembali, {{ Auth::user()->name }}!</h1>
        <p class="mt-1 text-gray-600">
            Anda login sebagai 
            <span class="font-semibold text-brand-primary">
                {{ Auth::user()->role->display_name ?? 'User' }}
            </span>. Ini adalah ringkasan aktivitas hari ini.
        </p>
    </div>

    {{-- Kartu Statistik --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        {{-- Kartu Total Restoran --}}
        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-brand-tint rounded-xl">
                    <svg class="w-6 h-6 text-brand-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Restoran</p>
                    <p class="text-2xl font-bold text-gray-800">5</p> {{-- Ganti dengan data asli --}}
                </div>
            </div>
        </div>
        @endif

        {{-- Kartu Pesanan Hari Ini --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Pesanan Hari Ini</p>
                    <p class="text-2xl font-bold text-gray-800">24</p> {{-- Ganti dengan data asli --}}
                </div>
            </div>
        </div>

        {{-- Kartu Pelanggan --}}
        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-yellow-100 rounded-xl">
                     <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Total Pelanggan</p>
                    <p class="text-2xl font-bold text-gray-800">120</p> {{-- Ganti dengan data asli --}}
                </div>
            </div>
        </div>
        @endif

        {{-- Kartu Poin Loyalitas --}}
        @if(Auth::user()->hasRole('customer'))
        <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-xl">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-12v4m-2-2h4m5 4v4m-2-2h4M17 3l-1.172 1.172a4 4 0 00-5.656 0L10 3m4 4l-1.172-1.172a4 4 0 00-5.656 0L6 7"></path></svg>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Poin Loyalitas Anda</p>
                    <p class="text-2xl font-bold text-gray-800">1,500</p> {{-- Ganti dengan data asli --}}
                </div>
            </div>
        </div>
        @endif
    </div>
@endsection