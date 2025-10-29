@extends('Dashboard.layout.master')
@section('title', 'Detail Menu')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Detail Menu: {{ $menu->name }}</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="md:col-span-1">
                @if($menu->image_path)
                    <img src="{{ asset('storage/' . $menu->image_path) }}" alt="{{ $menu->name }}" class="w-full h-auto object-cover rounded-lg shadow-md">
                @else
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg">
                        <span class="text-gray-500">Tidak ada gambar</span>
                    </div>
                @endif
            </div>
            <div class="md:col-span-2 space-y-4">
                <div>
                    <h2 class="text-sm font-bold text-gray-500 uppercase">Nama Menu</h2>
                    <p class="text-xl text-gray-800">{{ $menu->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-500 uppercase">Restoran</h2>
                    <p class="text-xl text-gray-800">{{ $menu->restoran->name }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-500 uppercase">Harga</h2>
                    <p class="text-xl text-gray-800 font-semibold text-brand-primary">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-gray-500 uppercase">Deskripsi</h2>
                    <p class="text-gray-700 leading-relaxed">{{ $menu->description ?? '-' }}</p>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-8">
            <a href="{{ route('Dashboard.menu.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300">Kembali</a>
        </div>
    </div>
@endsection