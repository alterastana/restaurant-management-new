@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-bold mb-4">Tabel Data Pengguna (Users)</h2>

    <div class="flex justify-between mb-4">
        <input type="text" placeholder="Cari Nama..." class="border px-3 py-2 rounded w-1/3">
        {{-- PERBAIKAN: Menggunakan nama rute 'users' --}}
    <a href="{{ route('Dashboard.users.create') }}" class="btn-secondary text-white px-4 py-2 rounded focus-brand">Tambah Pengguna</a>
    </div>

    <table class="w-full border text-left">
    <thead class="bg-brand-primary text-white">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Telepon</th>
                <th class="px-4 py-2">Peran</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($managers as $user) {{-- Kita ganti $manager menjadi $user agar lebih umum --}}
            <tr class="border-b">
                <td class="px-4 py-2">{{ $user->name }}</td>
                <td class="px-4 py-2">{{ $user->email }}</td>
                <td class="px-4 py-2">{{ $user->phone ?? '-' }}</td> {{-- Tambahkan fallback jika phone null --}}
                <td class="px-4 py-2">{{ $user->role->display_name ?? 'Tanpa Peran' }}</td> {{-- Menampilkan nama peran --}}
                <td class="px-4 py-2 space-x-2">
                    {{-- PERBAIKAN: Menggunakan nama rute 'users' --}}
                    <a href="{{ route('Dashboard.users.show', $user->id) }}" 
                       class="bg-green-600 text-white px-3 py-1 rounded">View</a>
                    <a href="{{ route('Dashboard.users.edit', $user->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('Dashboard.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus pengguna ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection