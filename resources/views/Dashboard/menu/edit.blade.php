@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">
    <h1 class="text-2xl font-semibold mb-6">Edit Menu</h1>

    <div class="bg-white p-6 rounded-lg shadow-md">
        {{-- Form kirim ke route update --}}
        <form action="{{ route('Dashboard.menu.update', $menu->menu_id) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- Kirim restaurant_id secara tersembunyi (agar tetap ada datanya) --}}
            <input type="hidden" name="restaurant_id" value="{{ $menu->restaurant_id }}">

            <div class="mb-4">
                <label for="name" class="block font-medium text-gray-700">Nama Menu</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $menu->name) }}"
                       class="w-full border-gray-300 rounded-md p-2">
            </div>

            <div class="mb-4">
                <label for="description" class="block font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="3"
                          class="w-full border-gray-300 rounded-md p-2">{{ old('description', $menu->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="price" class="block font-medium text-gray-700">Harga</label>
                <input type="number" name="price" id="price"
                       value="{{ old('price', $menu->price) }}"
                       class="w-full border-gray-300 rounded-md p-2">
            </div>

            <div class="mb-4">
                <label for="stock" class="block font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" id="stock"
                       value="{{ old('stock', $menu->stock) }}"
                       class="w-full border-gray-300 rounded-md p-2">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('Dashboard.menu.index') }}"
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                   Batal
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
