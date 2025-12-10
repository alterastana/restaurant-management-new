@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- 🔹 Back Button --}}
    <div class="mb-6">
        <a href="{{ route('landing.restaurants') }}"
           class="inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded shadow hover:bg-blue-700 transition">
            ← Kembali ke Daftar Restoran
        </a>
    </div>

    {{-- 🔹 Restaurant Header --}}
    <div class="bg-white rounded-lg shadow p-6 mb-10">
        <h1 class="text-3xl font-bold mb-4">{{ $restoran->name }}</h1>

        @if($restoran->description)
            <p class="text-gray-600 mb-4">{{ $restoran->description }}</p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
            {{-- Alamat --}}
            <div class="flex items-start gap-3">
                <div class="bg-blue-100 p-3 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                    </svg>
                </div>
                <div>
                    <h6 class="font-semibold text-blue-600 mb-1">Alamat</h6>
                    <p class="text-gray-600">{{ $restoran->address }}</p>
                </div>
            </div>

            {{-- Telepon --}}
            <div class="flex items-start gap-3">
                <div class="bg-green-100 p-3 rounded">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="currentColor" viewBox="0 0 16 16">
                        <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328z"/>
                    </svg>
                </div>
                <div>
                    <h6 class="font-semibold text-green-600 mb-1">Telepon</h6>
                    <p class="text-gray-600">{{ $restoran->phone }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- 🔹 Menu Section --}}
    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-bold mb-1">Menu Pilihan</h2>
            <p class="text-gray-500">Nikmati hidangan terbaik kami</p>
        </div>
        <span class="bg-gray-800 text-white px-3 py-1 rounded-full text-sm font-semibold">
            {{ $menus->count() }} Item
        </span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($menus as $menu)
            <div class="bg-white rounded-lg shadow p-5 flex flex-col justify-between">
                <div>
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg font-semibold">{{ $menu->name }}</h3>
                        <span class="text-sm font-medium px-2 py-1 rounded {{ $menu->stock > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $menu->stock > 0 ? 'Tersedia' : 'Habis' }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mb-4">{{ \Illuminate\Support\Str::limit($menu->description, 120) }}</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-gray-500 text-sm">Harga</span>
                        <span class="text-lg font-bold text-green-600">Rp {{ number_format($menu->price,0,',','.') }}</span>
                    </div>
                </div>
                @if($menu->stock > 0)
                    <a href="{{ route('orders.create', $restoran->restaurant_id) }}" 
                       class="mt-auto inline-block w-full text-center py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded shadow">
                       Pesan Sekarang
                    </a>
                @else
                    <button class="mt-auto w-full py-2 bg-gray-400 text-white font-semibold rounded" disabled>
                        Tidak Tersedia
                    </button>
                @endif
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">
                Tidak ada menu tersedia untuk restoran ini.
            </div>
        @endforelse
    </div>

</div>
@endsection
