@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6 max-w-lg mx-auto">
    <h2 class="text-lg font-bold mb-4">Detail Meja #{{ $table->table_number }}</h2>

    <div class="space-y-3">
        <p><strong>Nomor Meja:</strong> {{ $table->table_number }}</p>
        <p><strong>Kapasitas:</strong> {{ $table->capacity }}</p>
        <p><strong>Status:</strong> <span class="capitalize">{{ $table->status }}</span></p>
        <p><strong>Restoran:</strong> {{ $table->restaurant->name ?? '-' }}</p>
    </div>

    <div class="mt-6 flex justify-end space-x-2">
        <a href="{{ route('Dashboard.table.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        <a href="{{ route('Dashboard.table.edit', $table->table_id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
    </div>
</div>
@endsection