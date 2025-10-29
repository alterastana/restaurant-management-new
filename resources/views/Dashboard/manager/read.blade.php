@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    {{-- PERBAIKAN: Menggunakan $manager --}}
    <h2 class="text-lg font-bold mb-4">Detail Pengguna: {{ $manager->name }}</h2>

    <div class="space-y-4">
        <div>
            <strong class="text-gray-600">Nama:</strong>
            {{-- PERBAIKAN: Menggunakan $manager --}}
            <p>{{ $manager->name }}</p>
        </div>
        <div>
            <strong class="text-gray-600">Email:</strong>
            {{-- PERBAIKAN: Menggunakan $manager --}}
            <p>{{ $manager->email }}</p>
        </div>
        <div>
            <strong class="text-gray-600">Telepon:</strong>
            {{-- PERBAIKAN: Menggunakan $manager --}}
            <p>{{ $manager->phone ?? '-' }}</p>
        </div>
        <div>
            <strong class="text-gray-600">Peran:</strong>
            {{-- PERBAIKAN: Menggunakan $manager --}}
            <p>{{ $manager->role->display_name ?? 'Tanpa Peran' }}</p>
        </div>
        <div>
            <strong class="text-gray-600">Terdaftar Sejak:</strong>
            {{-- PERBAIKAN: Menggunakan $manager --}}
            <p>{{ $manager->created_at ? $manager->created_at->format('d M Y H:i') : '-' }}</p>
        </div>
    </div>

    <div class="mt-6 flex space-x-2">
        {{-- PERBAIKAN: Rute kembali ke 'users.index' --}}
        <a href="{{ route('Dashboard.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        
        {{-- PERBAIKAN: Menggunakan $manager --}}
        <a href="{{ route('Dashboard.users.edit', $manager->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
        
        {{-- PERBAIKAN: Menggunakan $manager --}}
        <form action="{{ route('Dashboard.users.destroy', $manager->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengguna ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Delete</button>
        </form>
    </div>
</div>
@endsection