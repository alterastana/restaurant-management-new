@extends('Dashboard.layout.master')

@section('title', 'Detail Restoran')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">{{ $restoran->name }}</h1>
            <p class="text-gray-500 mt-1">Detail lengkap informasi restoran.</p>
        </div>
        <a href="{{ route('Dashboard.restoran.index') }}" 
           class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 hover:bg-gray-300 rounded-lg">
           &larr; Kembali
        </a>
    </div>

    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <div class="space-y-6">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 text-indigo-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-500">Nama Restoran</h3>
                    <p class="text-gray-800 text-lg">{{ $restoran->name }}</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 text-indigo-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-500">Alamat</h3>
                    <p class="text-gray-800 whitespace-pre-line">{{ $restoran->address }}</p>
                </div>
            </div>

            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 text-indigo-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-500">Telepon</h3>
                    <p class="text-gray-800">{{ $restoran->phone }}</p>
                </div>
            </div>
            
            <div class="flex items-start">
                <div class="flex-shrink-0 w-8 text-indigo-500">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-500">Email</h3>
                    <p class="text-gray-800">{{ $restoran->email }}</p>
                </div>
            </div>
        </div>

        @if(Auth::user()->hasRole('admin') || Auth::user()->hasRole('manager'))
        <div class="mt-8 border-t pt-6 flex justify-end">
             <a href="{{ route('Dashboard.restoran.edit', $restoran) }}" class="px-6 py-2 text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-md">
                Edit Restoran Ini
            </a>
        </div>
        @endif
    </div>
@endsection