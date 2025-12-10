@extends('layouts.public')

@section('content')
<div class="container py-12 mx-auto">
    <div class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md text-center">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Pembayaran</h1>

        <p><strong>Nama:</strong> {{ $customer->name }}</p>
        <p><strong>Email:</strong> {{ $customer->email }}</p>
        <p><strong>Telepon:</strong> {{ $customer->phone }}</p>

        <h2 class="mt-8 mb-4 text-xl font-semibold text-gray-800">Daftar Pesanan</h2>

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

        <div class="flex justify-between mt-4 text-lg font-bold">
            <span>Total:</span>
            <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
        </div>

        <form action="{{ route('payment.process') }}" method="POST" class="mt-8">
            @csrf
            <button type="submit" class="px-6 py-3 font-bold text-white bg-green-600 rounded-md hover:bg-green-700">
                Bayar Sekarang
            </button>
        </form>
    </div>
</div>
@endsection
