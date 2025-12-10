{{-- resources/views/orders/show.blade.php --}}
@extends('layouts.dashboard')

@section('header')
<div class="flex justify-between items-center">
    <!-- ID Order di judul -->
    <h1 class="text-xl font-semibold text-gray-800">Detail Order #{{ $order->order_id }}</h1>
    <a href="{{ route('Dashboard.order.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded-lg transition duration-150 ease-in-out">Kembali</a>
</div>
@endsection

@section('dashboard-content')

<div class="bg-white rounded-2xl shadow-lg p-6 space-y-6">

    <!-- INFORMASI UMUM ORDER -->
    <div class="grid grid-cols-2 gap-4 text-sm md:text-base">
        <div>
            <strong>ID Order:</strong> 
            <span class="text-gray-900 font-medium break-all">{{ $order->order_id }}</span>
        </div>
        <div>
            <strong>Tanggal Order:</strong> 
            {{ $order->created_at->format('d/m/Y H:i') }}
        </div>
        <div>
            <strong>Status Order:</strong> 
            @php
                $statusClass = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'preparing' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ][$order->status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="capitalize px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">{{ $order->status }}</span>
        </div>
        <div>
            <strong>Status Pembayaran:</strong> 
            @php
                $paymentClass = [
                    'paid' => 'bg-green-100 text-green-800',
                    'unpaid' => 'bg-red-100 text-red-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                ][$order->payment_status ?? 'unpaid'] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="capitalize px-3 py-1 text-xs font-semibold rounded-full {{ $paymentClass }}">{{ $order->payment_status ?? 'Unpaid' }}</span>
        </div>
        <div>
            <strong>Total:</strong> 
            <span class="text-lg font-bold text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
        </div>
        @if($order->notes)
            <div class="col-span-2 mt-2 p-3 bg-gray-50 rounded-lg border border-gray-200">
                <strong>Catatan:</strong> {{ $order->notes }}
            </div>
        @endif
    </div>

    <!-- INFORMASI RESERVASI -->
    @if($order->reservation)
    <div class="grid grid-cols-2 gap-4 text-sm md:text-base mt-4">
        <div>
            <strong>Nama Customer:</strong> {{ $order->reservation->customer_name }}
        </div>
        <div>
            <strong>Meja:</strong> {{ $order->reservation->table_number }}
        </div>
        <div>
            <strong>Waktu Reservasi:</strong> {{ \Carbon\Carbon::parse($order->reservation->reservation_time)->format('d/m/Y H:i') }}
        </div>
    </div>
    @endif

    <!-- INFORMASI PEMBAYARAN -->
    @if($order->payment)
    <div class="grid grid-cols-2 gap-4 text-sm md:text-base mt-4">
        <div>
            <strong>Metode Pembayaran:</strong> {{ ucfirst($order->payment->method ?? '-') }}
        </div>
        <div>
            <strong>Jumlah Dibayar:</strong> Rp {{ number_format($order->payment->amount ?? 0, 0, ',', '.') }}
        </div>
        <div>
            <strong>Status Pembayaran:</strong>
            @php
                $paymentClass = [
                    'paid' => 'bg-green-100 text-green-800',
                    'unpaid' => 'bg-red-100 text-red-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                ][$order->payment->status ?? 'unpaid'] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="capitalize px-3 py-1 text-xs font-semibold rounded-full {{ $paymentClass }}">
                {{ $order->payment->status ?? 'Unpaid' }}
            </span>
        </div>
    </div>
    @endif

    <!-- ITEM ORDER -->
    <h2 class="text-lg font-semibold mb-3 pt-4 border-t">Item Order</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Menu</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Harga</th>
                    <th class="px-4 py-3 text-center text-xs font-medium text-gray-600 uppercase tracking-wider">Qty</th>
                    <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 uppercase tracking-wider">Subtotal</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($order->orderDetails as $detail)
                <tr>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900">{{ $detail->menu->name ?? 'N/A' }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-right text-gray-700">Rp {{ number_format($detail->price,0,',','.') }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm text-center text-gray-700">{{ $detail->quantity }}</td>
                    <td class="px-4 py-2 whitespace-nowrap text-sm font-semibold text-right text-gray-900">Rp {{ number_format($detail->price * $detail->quantity,0,',','.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-4 text-center text-sm text-gray-500 italic">Tidak ada item yang terdaftar untuk pesanan ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
