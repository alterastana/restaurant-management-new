@extends('Dashboard.layout.master')

@section('title', 'Selamat Datang')

@section('content')
    {{-- Bagian Header dengan Sapaan Personal --}}
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Selamat Datang, {{ Auth::user()->name }}!</h1>
        <p class="mt-1 text-gray-600">Siap untuk pengalaman kuliner terbaik? Pesan meja atau menu favorit Anda sekarang.</p>
    </div>

    {{-- Kartu Aksi Cepat untuk Customer --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <a href="#" class="block p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-blue-100 rounded-xl">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-800">Reservasi Meja</h3>
                    <p class="text-sm text-gray-500 mt-1">Amankan tempat Anda di restoran favorit.</p>
                </div>
            </div>
        </a>

        <a href="{{ route('Dashboard.restoran.index') }}" class="block p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-green-100 rounded-xl">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-800">Lihat Menu & Restoran</h3>
                    <p class="text-sm text-gray-500 mt-1">Jelajahi berbagai hidangan lezat.</p>
                </div>
            </div>
        </a>
        
        <a href="{{ route('Dashboard.loyalty.index') }}" class="block p-8 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="p-3 bg-purple-100 rounded-xl">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-12v4m-2-2h4m5 4v4m-2-2h4M17 3l-1.172 1.172a4 4 0 00-5.656 0L10 3m4 4l-1.172-1.172a4 4 0 00-5.656 0L6 7"></path></svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-xl font-bold text-gray-800">Poin Loyalitas</h3>
                    <p class="text-sm text-gray-500 mt-1">Cek poin dan tukarkan dengan hadiah.</p>
                </div>
            </div>
        </a>

    </div>
@endsection