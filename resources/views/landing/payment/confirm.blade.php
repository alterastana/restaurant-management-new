<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Konfirmasi Pembayaran
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Detail Pesanan</h3>

                    <div class="border rounded-lg p-4 mb-6">
                        <p><strong>Nama:</strong> {{ $customer->name }}</p>
                        <p><strong>Email:</strong> {{ $customer->email }}</p>
                        <p><strong>Telepon:</strong> {{ $customer->phone }}</p>
                    </div>

                    <div class="space-y-3 mb-6">
                        @foreach($cart as $item)
                            <div class="flex justify-between">
                                <span>{{ $item['name'] }} (x{{ $item['quantity'] }})</span>
                                <span>Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                        <div class="border-t pt-3 flex justify-between">
                            <span class="text-lg font-semibold">Total:</span>
                            <span class="text-xl font-bold text-blue-600">
                                Rp {{ number_format($total, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        <div class="flex gap-4">
                            <button type="submit" class="flex-1 bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded">
                                Bayar Sekarang
                            </button>
                            <a href="{{ url('/') }}" class="flex-1 bg-gray-500 hover:bg-gray-700 text-white font-bold py-3 px-4 rounded text-center">
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
