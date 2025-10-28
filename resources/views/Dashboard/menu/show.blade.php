@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">Detail Menu</h2>

        <div class="mb-3">
            <strong>Nama Menu:</strong> {{ $menu->name }}
        </div>
        <div class="mb-3">
            <strong>Deskripsi:</strong> {{ $menu->description ?? '-' }}
        </div>
        <div class="mb-3">
            <strong>Harga:</strong> Rp {{ number_format($menu->price, 0, ',', '.') }}
        </div>
        <div class="mb-3">
            <strong>Stok:</strong> {{ $menu->stock }}
        </div>
        <div class="mb-3">
            <strong>Restaurant ID:</strong> {{ $menu->restaurant_id }}
        </div>

        <a href="{{ route('Dashboard.menu.index') }}"
           class="mt-4 inline-block bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
           Kembali
        </a>
    </div>
</div>
@endsection
