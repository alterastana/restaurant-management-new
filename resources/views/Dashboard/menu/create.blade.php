@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    <h1 class="text-2xl font-semibold text-gray-800 mb-6">Tambah Menu Baru</h1>

    <form action="{{ route('Dashboard.menu.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <div class="mb-4">
            <label class="block mb-2 text-gray-700">Nama Menu</label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mb-4">
            <label class="block mb-2 text-gray-700">Deskripsi</label>
            <textarea name="description" class="w-full p-2 border border-gray-300 rounded-md"></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block mb-2 text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
            <div>
                <label class="block mb-2 text-gray-700">Stok</label>
                <input type="number" name="stock" class="w-full p-2 border border-gray-300 rounded-md" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="block mb-2 text-gray-700">Restaurant ID</label>
            <input type="number" name="restaurant_id" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('Dashboard.menu.index') }}"
               class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md">Kembali</a>
            <button type="submit"
                    class="btn-secondary text-white px-4 py-2 rounded-md focus-brand">Simpan</button>
        </div>
    </form>
</div>
@endsection
