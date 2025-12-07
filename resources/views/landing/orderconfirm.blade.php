@extends('layouts.public')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 px-4">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg overflow-hidden">

        <!-- Header -->
        <div class="bg-red-700 text-white text-center py-6">
            <h1 class="text-2xl font-bold">Konfirmasi Pesanan</h1>
            <p class="text-sm opacity-90">Periksa kembali pesanan Anda sebelum melanjutkan</p>
        </div>

        <div class="p-8 space-y-6">

            <!-- Data Pemesan -->
            <div class="grid md:grid-cols-3 gap-4 border rounded-lg p-4 bg-gray-50">
                <div>
                    <p class="text-sm text-gray-500">Nama</p>
                    <p class="font-semibold text-gray-800">{{ $order['name'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Email</p>
                    <p class="font-semibold text-gray-800">{{ $order['email'] }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Telepon</p>
                    <p class="font-semibold text-gray-800">{{ $order['phone'] }}</p>
                </div>
            </div>

            <!-- Daftar Pesanan -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Daftar Pesanan</h2>

                @if(!empty($cart))
                    <div class="border rounded-lg divide-y">
                        @foreach($cart as $item)
                            <div class="flex justify-between items-center px-4 py-3">
                                <div>
                                    <p class="font-semibold text-gray-800">{{ $item['name'] }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                                </div>
                                <p class="font-bold text-green-600">
                                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    <!-- Total -->
                    <div class="flex justify-between items-center mt-4 p-4 bg-green-50 rounded-lg text-lg font-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-green-700">
                            Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 0, ',', '.') }}
                        </span>
                    </div>
                @else
                    <p class="text-center text-gray-500">Keranjang kosong.</p>
                @endif
            </div>

            <!-- Form Konfirmasi -->
            <form action="{{ route('payment.process') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Jenis Pesanan -->
                <div>
                    <p class="mb-3 font-semibold text-gray-700">Jenis Pesanan</p>
                    <div class="grid grid-cols-2 gap-4">
                        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:border-green-500">
                            <input type="radio" name="order_type" value="dine-in" required>
                            <span>Dine-In</span>
                        </label>

                        <label class="flex items-center gap-2 p-3 border rounded-lg cursor-pointer hover:border-green-500">
                            <input type="radio" name="order_type" value="takeaway" required>
                            <span>Takeaway</span>
                        </label>
                    </div>
                </div>

                <!-- Catatan -->
                <div>
                    <label class="block mb-2 font-semibold text-gray-700">
                        Catatan Pelanggan (Opsional)
                    </label>
                    <textarea 
                        name="note" 
                        rows="3"
                        class="w-full rounded-lg border-gray-300 focus:ring-green-500 focus:border-green-500"
                        placeholder="Contoh: tanpa sambal, lebih pedas, dll..."></textarea>
                </div>

                <!-- Tombol -->
                <div class="flex flex-col md:flex-row gap-4 mt-6">
                    <button type="submit" 
                        class="w-full md:w-1/2 py-3 rounded-lg bg-green-600 text-white font-bold hover:bg-green-700 transition">
                        Konfirmasi & Bayar
                    </button>

                    <a href="{{ route('landing.checkout') }}" 
                        class="w-full md:w-1/2 py-3 rounded-lg bg-gray-500 text-white font-bold text-center hover:bg-gray-600 transition">
                        Kembali
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
