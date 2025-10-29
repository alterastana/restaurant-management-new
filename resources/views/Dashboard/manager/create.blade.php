@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-bold mb-4">Tambah Pengguna Manager Baru</h2>

    {{-- INI BARIS YANG DIPERBAIKI (sekitar baris 7) --}}
    <form action="{{ route('Dashboard.users.store') }}" method="POST">
        @csrf

        <div class="space-y-4">
            <div>
                <label for="name" class="block font-medium">Nama</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" class="border px-3 py-2 rounded w-full @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block font-medium">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="border px-3 py-2 rounded w-full @error('email') border-red-500 @enderror" required>
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="phone" class="block font-medium">Telepon</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="border px-3 py-2 rounded w-full @error('phone') border-red-500 @enderror">
                @error('phone')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block font-medium">Password</label>
                <input type="password" name="password" id="password" class="border px-3 py-2 rounded w-full @error('password') border-red-500 @enderror" required>
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block font-medium">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="border px-3 py-2 rounded w-full" required>
            </div>
        </div>

        <div class="mt-6 flex space-x-2">
            {{-- PERBAIKAN: Rute kembali ke 'users.index' --}}
            <a href="{{ route('Dashboard.users.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" class="btn-secondary text-white px-4 py-2 rounded focus-brand">Simpan</button>
        </div>
    </form>
</div>
@endsection