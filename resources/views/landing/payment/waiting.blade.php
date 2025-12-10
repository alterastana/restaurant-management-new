@extends('layouts.public')

@section('content')
<div class="container py-12 mx-auto">
    <div class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md text-center">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Menunggu Pembayaran</h1>

        {{-- @php
            dd($payment);    
        @endphp --}}
        <p class="text-gray-600 mb-6">
            Terima kasih, {{ $payment['name'] }}. Pesanan kamu sedang menunggu pembayaran.
        </p>
        <div class="border rounded-md divide-y divide-gray-200">
            @foreach($payment['cart'] as $item)
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

        <div class="flex justify-between mt-4 text-lg font-bold">
            <span>Total:</span>
            <span>Rp {{ number_format($payment['total'], 0, ',', '.') }}</span>
        </div>

        <p class="mt-8 text-gray-500">Silakan selesaikan pembayaran untuk memproses pesanan Anda.</p>

        <a href="{{ $payment['payment_url'] }}" class="mt-6 inline-block px-6 py-3 font-bold text-white bg-blue-600 rounded-md hover:bg-blue-700">
            Lanjut bayar
        </a>
    </div>
</div>
@endsection
