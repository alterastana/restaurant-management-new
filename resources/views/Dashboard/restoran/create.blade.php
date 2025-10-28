@extends('Dashboard.layout.master')

@section('title', 'Tambah Restoran Baru')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Tambah Restoran Baru</h1>

    <div class="bg-white p-8 rounded-2xl shadow-lg">
        
        {{-- Menampilkan Error Validasi --}}
        @if ($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg" role="alert">
                <p class="font-bold">Oops! Ada beberapa kesalahan:</p>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('Dashboard.restoran.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Nama Restoran --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Restoran</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Nomor Telepon --}}
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor Telepon</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>

                {{-- Email --}}
                <div class="md:col-span-2">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           required>
                </div>
                
                {{-- Alamat --}}
                <div class="md:col-span-2">
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                    <textarea name="address" id="address" rows="4"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                              required>{{ old('address') }}</textarea>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex items-center justify-end mt-8 gap-4">
                <a href="{{ route('Dashboard.restoran.index') }}" 
                   class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg">
                   Batal
                </a>
                <button type="submit" 
                        class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-md">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection