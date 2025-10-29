@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Menu</h2>

        <form action="{{ route('Dashboard.menu.update', $menu->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">Restaurant ID</label>
                <input type="number" name="restaurant_id" value="{{ old('restaurant_id', $menu->restaurant_id) }}"
                       class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">Nama Menu</label>
                <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                       class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                          class="w-full border border-gray-300 rounded-md p-2">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">Harga</label>
                <input type="number" name="price" value="{{ old('price', $menu->price) }}"
                       class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold text-gray-700 mb-2">Stok</label>
                <input type="number" name="stock" value="{{ old('stock', $menu->stock) }}"
                       class="w-full border border-gray-300 rounded-md p-2" required>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('Dashboard.menu.index') }}"
                   class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">
                   Kembali
                </a>
                <button type="submit"
                        class="btn-secondary text-white px-6 py-2 rounded-md focus-brand">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
