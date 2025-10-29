@extends('layouts.app')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tambah Meja Baru (Create)</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <form action="{{ route('Dashboard.table.store') }}" method="POST">
            @csrf
            <div class="space-y-6">
                <div>
                    <label for="restaurant_id" class="block font-medium">Restoran</label>
                    <select name="restaurant_id" id="restaurant_id" class="mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="">Pilih Restoran</option>
                        @foreach($restorans as $restoran)
                            <option value="{{ $restoran->id }}">{{ $restoran->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="table_number" class="block font-medium">Nomor Meja</label>
                    <input type="number" name="table_number" id="table_number" placeholder="e.g., 1, 2, 10" class="mt-1 w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label for="capacity" class="block font-medium">Kapasitas</label>
                    <input type="number" name="capacity" id="capacity" min="1" class="mt-1 w-full rounded-lg border-gray-300" required>
                </div>
                <div>
                    <label for="status" class="block font-medium">Status</label>
                    <select name="status" id="status" class="mt-1 w-full rounded-lg border-gray-300" required>
                        <option value="available">Available</option>
                        <option value="occupied">Occupied</option>
                        <option value="reserved">Reserved</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <a href="{{ route('Dashboard.table.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 mr-4">Batal</a>
                <button type="submit" class="px-6 py-2 btn-secondary rounded-lg focus-brand">Simpan</button>
            </div>
        </form>
    </div>
@endsection