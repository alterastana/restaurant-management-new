@extends('layouts.dashboard')

@section('header')
<h2 class="font-semibold text-xl text-gray-800 leading-tight">Payments</h2>
@endsection

@section('dashboard-content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-2xl font-bold mb-6 text-gray-800">Daftar Payments</h3>

    @if($payments->isEmpty())
        <p class="text-gray-500">Tidak ada data pembayaran.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                <thead class="bg-red-600 text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-sm font-semibold">ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Order ID</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Customer</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Amount</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Status</th>
                        <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->payment_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->order_id }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">{{ $payment->order->customer->name ?? 'N/A' }}</td>
                        <td class="px-4 py-2 text-sm text-gray-700">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="px-4 py-2 text-sm font-semibold
                            @if($payment->status === 'failed') text-red-600
                            @elseif($payment->status === 'pending') text-yellow-500
                            @elseif($payment->status === 'completed') text-green-600
                            @else text-gray-700 @endif">
                            {{ ucfirst($payment->status) }}
                        </td>
                        <td class="px-4 py-2 text-sm">
                            <a href="{{ route('Dashboard.payments.show', $payment) }}" 
                               class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition duration-150">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $payments->links() }}
        </div>
    @endif
</div>
@endsection
