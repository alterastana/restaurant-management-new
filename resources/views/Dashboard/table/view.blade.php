@extends('layouts.dashboard')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">Detail Meja: {{ $table->table_number }}</h1>
@endsection

@section('dashboard-content')
    
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h2 class="text-sm font-bold text-gray-500 uppercase">Nomor Meja</h2>
                <p class="text-2xl text-gray-900">{{ $table->table_number }}</p>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-500 uppercase">Restoran</h2>
                <p class="text-2xl text-gray-900">{{ $table->restoran->name ?? 'Restoran Dihapus' }}</p>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-500 uppercase">Kapasitas</h2>
                <p class="text-2xl text-gray-900">{{ $table->capacity }} orang</p>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-500 uppercase">Status</h2>
                <p class="text-2xl text-gray-900 capitalize 
                    {{ $table->status == 'available' ? 'text-green-600' : 'text-red-600' }}">
                    {{ $table->status }}
                </p>
            </div>
        </div>

        <div class="border-t mt-8 pt-6">
            <h2 class="text-sm font-bold text-gray-500 uppercase">Informasi Lain</h2>
            
            <p class="text-gray-700 mt-2">
                Meja ini ditambahkan pada:
                @if($table->created_at)
                    {{ $table->created_at->format('d M Y') }}
                @else
                    - (Data tanggal tidak tersedia)
                @endif
            </p>
        </div>

        <div class="flex justify-end mt-8 space-x-4">
            <a href="{{ route('Dashboard.table.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300">Kembali</a>
            <a href="{{ route('Dashboard.table.edit', $table) }}" class="py-2 px-6 rounded-lg text-white bg-yellow-500 hover:bg-yellow-600">Edit</a>
        </div>
    </div>
@endsection