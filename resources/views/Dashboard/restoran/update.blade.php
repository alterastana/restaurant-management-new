@extends('Dashboard.layout.master')

@section('title', 'Edit Restoran')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Edit Restoran</h1>

    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <form action="{{ route('Dashboard.restoran.update', $restoran) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="space-y-6">
                <div>
                    <label for="name" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        <span>Nama Restoran</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name', $restoran->name) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                </div>

                <div>
                    <label for="address" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                         <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span>Alamat</span>
                    </label>
                    <textarea name="address" id="address" rows="4" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>{{ old('address', $restoran->address) }}</textarea>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="phone" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            <span>Nomor Telepon</span>
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ old('phone', $restoran->phone) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                    <div>
                        <label for="email" class="flex items-center text-sm font-medium text-gray-700 mb-1">
                            <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            <span>Email</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email', $restoran->email) }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg" required>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end mt-8 gap-4">
                <a href="{{ route('Dashboard.restoran.index') }}" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg">Batal</a>
                <button type="submit" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-md">Update</button>
            </div>
        </form>
    </div>
@endsection