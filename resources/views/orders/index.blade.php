{{-- resources/views/orders/index.blade.php --}}
@extends('layouts.dashboard')

@section('title', 'Manajemen Order')

@section('content')

<div class="container mx-auto px-4 py-8 sm:px-6 lg:px-8">
<h1 class="text-3xl font-bold text-gray-900 mb-6 border-b pb-2">Manajemen Order</h1>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 shadow-md" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 shadow-md" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
@endif

{{-- Filter dan Search --}}
<div class="flex flex-col sm:flex-row justify-between items-center mb-6 space-y-4 sm:space-y-0 bg-white p-4 rounded-2xl shadow-lg border border-gray-100">
    <form action="{{ route('Dashboard.order.index') }}" method="GET" class="w-full sm:w-2/3 flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-3">
        <div class="relative flex-grow">
            <input type="search" name="search" placeholder="Cari ID atau Nama Customer..." 
                   value="{{ request('search') }}"
                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-xl focus:ring-red-500 focus:border-red-500 transition duration-150 shadow-sm">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
        </div>

        <select name="status_filter" onchange="this.form.submit()" class="border border-gray-300 rounded-xl py-2 px-3 text-sm focus:ring-red-500 focus:border-red-500 transition duration-150 w-full sm:w-auto shadow-sm">
            <option value="">Semua Status</option>
            <option value="pending" @if(request('status_filter') === 'pending') selected @endif>Pending</option>
            <option value="processing" @if(request('status_filter') === 'processing') selected @endif>Processing</option>
            <option value="ready" @if(request('status_filter') === 'ready') selected @endif>Ready</option>
            <option value="completed" @if(request('status_filter') === 'completed') selected @endif>Completed</option>
            <option value="cancelled" @if(request('status_filter') === 'cancelled') selected @endif>Cancelled</option>
        </select>
        
        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-xl shadow-sm transition duration-300 w-full sm:w-auto">
            Terapkan Filter
        </button>
    </form>
</div>

@if($orders->count() > 0)
    <div class="bg-white shadow-xl rounded-2xl overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-red-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">#ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Tipe Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Customer</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Status Order</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Status Bayar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-red-700 uppercase tracking-wider">Tanggal Dibuat</th>
                        <th class="px-6 py-3 text-center text-xs font-medium text-red-700 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($orders as $order)
                        <tr class="hover:bg-red-50 transition duration-150">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-900">{{ substr($order->order_id, 0, 8) }}...</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $typeKey = strtolower($order->order_type);
                                    $typeClasses = [
                                        'dine-in' => 'bg-red-100 text-red-800',
                                        'takeaway' => 'bg-red-100 text-red-800',
                                        'default' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $typeClass = $typeClasses[$typeKey] ?? $typeClasses['default'];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $typeClass }}">
                                    {{ ucfirst($order->order_type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $order->customer->name ?? 'Anonim' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'processing' => 'bg-blue-100 text-blue-800',
                                        'ready' => 'bg-indigo-100 text-indigo-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'default' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $statusKey = strtolower($order->status);
                                    $class = $statusClasses[$statusKey] ?? $statusClasses['default'];
                                @endphp
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $class }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                @php
                                    $paymentClasses = [
                                        'paid' => 'bg-green-100 text-green-700',
                                        'unpaid' => 'bg-red-100 text-red-700',
                                        'partial' => 'bg-yellow-100 text-yellow-700',
                                        'refunded' => 'bg-gray-100 text-gray-700',
                                        'default' => 'bg-gray-100 text-gray-700',
                                    ];
                                    $paymentStatusKey = strtolower($order->payment_status ?? 'unpaid');
                                    $paymentClass = $paymentClasses[$paymentStatusKey] ?? $paymentClasses['default'];
                                @endphp
                                <span class="px-2 py-0.5 inline-flex text-xs leading-5 font-medium rounded-full {{ $paymentClass }}">
                                    {{ ucfirst($order->payment_status ?? 'Unpaid') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y') }} <br> 
                                <span class="text-xs text-gray-400">{{ $order->created_at->format('H:i') }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('Dashboard.order.show', $order) }}" title="Lihat Detail" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition duration-150">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </a>
                                    <form action="{{ route('Dashboard.order.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus order ID {{ substr($order->order_id, 0, 8) }}...?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 transition duration-150">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $orders->links() }}
    </div>

@else
    <div class="bg-gray-50 border border-dashed border-gray-300 p-10 rounded-xl text-center shadow-inner">
        <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        <h3 class="text-lg font-medium text-gray-900">Tidak ada Order ditemukan</h3>
        <p class="mt-1 text-sm text-gray-500">
            Saat ini, tidak ada order yang cocok dengan kriteria pencarian atau filter.
        </p>
    </div>
@endif

</div>
@endsection
