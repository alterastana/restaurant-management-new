@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-lg font-bold mb-4">Tambah Meja Baru</h2>

    <form action="{{ route('Dashboard.table.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="restaurant_id" class="block font-medium">Restoran</label>
            <select name="restaurant_id" id="restaurant_id" class="w-full border rounded px-3 py-2">
                @foreach($restaurants as $restaurant)
                    <option value="{{ $restaurant->restaurant_id }}">{{ $restaurant->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="table_number" class="block font-medium">Nomor Meja</label>
            <input type="number" name="table_number" id="table_number" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="capacity" class="block font-medium">Kapasitas</label>
            <input type="number" name="capacity" id="capacity" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label for="status" class="block font-medium">Status</label>
            <select name="status" id="status" class="w-full border rounded px-3 py-2">
                <option value="available">Tersedia</option>
                <option value="reserved">Dipesan</option>
                <option value="occupied">Terisi</option>
            </select>
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('Dashboard.table.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Simpan</button>
        </div>
    </form>
</div>
@endsection