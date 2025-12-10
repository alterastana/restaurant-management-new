@extends('layouts.dashboard')

@section('header')
<h2 class="font-semibold text-xl text-white leading-tight bg-red-600 p-4 rounded">
    Payment Detail
</h2>
@endsection

@section('dashboard-content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">Detail Payment #{{ $payment->payment_id }}</h3>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Kolom Kiri -->
        <div class="space-y-3">
            <p><strong class="text-gray-700">Payment ID:</strong> <span class="text-gray-800">{{ $payment->payment_id }}</span></p>
            <p><strong class="text-gray-700">Order ID:</strong> <span class="text-gray-800">{{ $payment->order_id }}</span></p>
            <p><strong class="text-gray-700">Customer:</strong> <span class="text-gray-800">{{ $payment->order->customer->name ?? 'N/A' }}</span></p>
            <p><strong class="text-gray-700">Amount:</strong> <span class="text-gray-800">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span></p>
            <p><strong class="text-gray-700">Status:</strong>
                @php
                    $statusColor = match($payment->status) {
                        'failed' => 'bg-red-600',
                        'pending' => 'bg-yellow-500',
                        'completed' => 'bg-green-600',
                        default => 'bg-gray-400',
                    };
                @endphp
                <span class="px-3 py-1 rounded-full text-white text-sm font-semibold {{ $statusColor }}">
                    {{ ucfirst($payment->status) }}
                </span>
            </p>
        </div>

        <!-- Kolom Kanan -->
        <div class="space-y-3">
            <p><strong class="text-gray-700">Payment Method:</strong> <span class="text-gray-800">{{ ucfirst($payment->payment_method) }}</span></p>
            <p><strong class="text-gray-700">Reservation:</strong> <span class="text-gray-800">{{ $payment->reservation_id ?? '-' }}</span></p>
            <p><strong class="text-gray-700">Created At:</strong> <span class="text-gray-800">{{ $payment->created_at->format('d-m-Y H:i:s') }}</span></p>
            <p><strong class="text-gray-700">Updated At:</strong> <span class="text-gray-800">{{ $payment->updated_at->format('d-m-Y H:i:s') }}</span></p>
            @if($payment->payment_url)
                <p><strong class="text-gray-700">Payment URL:</strong> 
                    <a href="{{ $payment->payment_url }}" class="text-red-600 hover:underline" target="_blank">Lihat Pembayaran</a>
                </p>
            @endif
        </div>
    </div>

    <!-- Tombol Kembali -->
    <div class="mt-6">
        <a href="{{ route('Dashboard.payments.index') }}" 
           class="px-5 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition duration-200 font-semibold">
            Kembali ke Daftar Payments
        </a>
    </div>
</div>
@endsection
