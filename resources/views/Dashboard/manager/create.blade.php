@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-bold mb-4">Tambah Manager</h2>

    <form action="{{ route('Dashboard.manager.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block font-medium">Nama</label>
            <input type="text" name="name" id="name" 
                class="w-full border px-3 py-2 rounded" 
                value="{{ old('name') }}" required>
            @error('name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block font-medium">Email</label>
            <input type="email" name="email" id="email" 
                class="w-full border px-3 py-2 rounded" 
                value="{{ old('email') }}" required>
            @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="phone" class="block font-medium">Telepon</label>
            <input type="text" name="phone" id="phone" 
                class="w-full border px-3 py-2 rounded" 
                value="{{ old('phone') }}">
            @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block font-medium">Password</label>
            <input type="password" name="password" id="password" 
                class="w-full border px-3 py-2 rounded" required>
            @error('password') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
        </div>

        <div class="flex justify-end space-x-2">
            <a href="{{ route('Dashboard.manager.index') }}" 
                class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
            <button type="submit" 
                class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
        </div>
    </form>
</div>
@endsection
