@extends('layouts.public')

@section('content')
<div class="container py-12 mx-auto">
    <div class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md text-center">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Konfirmasi Pesanan</h1>

        <p><strong>Nama:</strong> {{ $order['name'] }}</p>
        <p><strong>Email:</strong> {{ $order['email'] }}</p>
        <p><strong>Telepon:</strong> {{ $order['phone'] }}</p>

        <!-- ✅ Cart Items -->
        <h2 class="mt-8 mb-4 text-xl font-semibold text-gray-800">Daftar Pesanan</h2>

        @if(!empty($cart))
            <div class="border rounded-md divide-y divide-gray-200">
                @foreach($cart as $item)
                    <div class="flex justify-between px-4 py-3 text-left">
                        <div>
                            <p class="font-medium text-gray-900">{{ $item['name'] }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item['quantity'] }}</p>
                        </div>
                        <p class="font-semibold text-gray-800">
                            Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Total -->
            <div class="flex justify-between mt-4 text-lg font-bold">
                <span>Total:</span>
                <span>
                    Rp {{ number_format(collect($cart)->sum(fn($i) => $i['price'] * $i['quantity']), 0, ',', '.') }}
                </span>
            </div>
        @else
            <p class="mt-4 text-gray-500">Keranjang kosong.</p>
        @endif

        <!-- ✅ Form Konfirmasi -->
        <form action="{{ route('payment.process') }}" method="POST" class="mt-6">
            @csrf

            <!-- Pilihan Dine-In / Takeaway -->
            <div class="text-left">
                <p class="mb-2 text-gray-700 font-semibold">Pilih Jenis Pesanan:</p>

                <div class="flex flex-col gap-2">
                    <label class="inline-flex items-center">
                        <input type="radio" name="order_type" value="dine-in" class="text-green-600 border-gray-300 focus:ring-green-500" required>
                        <span class="ml-2">Dine-In (Makan di tempat)</span>
                    </label>

                    <label class="inline-flex items-center">
                        <input type="radio" name="order_type" value="takeaway" class="text-green-600 border-gray-300 focus:ring-green-500" required>
                        <span class="ml-2">Takeaway (Bawa pulang)</span>
                    </label>
                </div>
            </div>

            <!-- ✅ Catatan Pelanggan -->
            <div class="mt-5 text-left">
                <label for="note" class="block mb-2 text-gray-700 font-semibold">
                    Catatan Pelanggan (opsional):
                </label>
                <textarea 
                    id="note" 
                    name="note" 
                    rows="3" 
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500"
                    placeholder="Contoh: tanpa sambal, tambahkan sendok, dsb..."></textarea>
            </div>

            <!-- Tombol -->
            <div class="flex justify-center gap-4 mt-6">
                <button type="submit" class="px-6 py-3 font-bold text-white bg-green-600 rounded-md hover:bg-green-700">
                    Konfirmasi & Bayar
                </button>

                <a href="{{ route('landing.checkout') }}" class="px-6 py-3 font-bold text-white bg-gray-500 rounded-md hover:bg-gray-600">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
