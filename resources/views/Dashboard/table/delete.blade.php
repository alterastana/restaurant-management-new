@extends('layouts.app')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Hapus Meja (Delete)</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <p class="text-lg text-gray-700 mb-6">
            Apakah Anda yakin ingin menghapus meja nomor <strong>{{ $table->table_number }}</strong>
            di restoran <strong>{{ $table->restoran->name }}</strong>?
        </p>
        <p class="text-red-600 font-medium">Tindakan ini tidak dapat dibatalkan.</p>

        <div class="flex justify-end mt-8">
            <a href="{{ route('Dashboard.table.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 mr-4">Batal</a>
            <form action="{{ route('Dashboard.table.destroy', $table) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-lg">Ya, Hapus</button>
            </form>
        </div>
    </div>
@endsection