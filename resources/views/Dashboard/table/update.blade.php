@extends('layouts.app')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Meja (Update): {{ $table->table_number }}</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">

        <form action="{{ route('Dashboard.table.update', $table) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">

                <div>
                    <label for="restaurant_name" class="block font-medium">Restoran</label>

                    <input type="text" id="restaurant_name" 
                           value="{{ $table->restoran->name ?? 'Restoran Dihapus' }}" 
                           class="mt-1 w-full rounded-lg border-gray-300 bg-gray-100" 
                           disabled>

                    <input type="hidden" name="restaurant_id" value="{{ $table->restaurant_id }}">

                    @error('restaurant_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="table_number" class="block font-medium">Nomor Meja</label>
                    <input type="number" name="table_number" id="table_number" value="{{ old('table_number', $table->table_number) }}" class="mt-1 w-full rounded-lg border-gray-300 @error('table_number') border-red-500 @enderror" required>
                    @error('table_number')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacity" class="block font-medium">Kapasitas</label>
                    <input type="number" name="capacity" id="capacity" min="1" value="{{ old('capacity', $table->capacity) }}" class="mt-1 w-full rounded-lg border-gray-300 @error('capacity') border-red-500 @enderror" required>
                    @error('capacity')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block font-medium">Status</label>
                    <select name="status" id="status" class="mt-1 w-full rounded-lg border-gray-300 @error('status') border-red-500 @enderror" required>
                        <option value="available" {{ old('status', $table->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="occupied" {{ old('status', $table->status) == 'occupied' ? 'selected' : '' }}>Occupied</option>
                        <option value="reserved" {{ old('status', $table->status) == 'reserved' ? 'selected' : '' }}>Reserved</option>
                    </select>
                    @error('status')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end mt-8">
                <a href="{{ route('Dashboard.table.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 mr-4">Batal</a>
                <button type="submit" class="px-6 py-2 btn-secondary rounded-lg focus-brand">Update</button>
            </div>
        </form>
    </div>
@endsection