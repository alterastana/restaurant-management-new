@extends('layouts.public')

@section('content')
<div class="container py-12 mx-auto">
    <div class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md">
        <h1 class="mb-6 text-3xl font-bold text-center text-gray-800">Checkout</h1>

        <form action="{{ route('landing.order.store') }}" method="POST">
            @csrf

            <h2 class="mb-4 text-xl font-semibold text-gray-700">Informasi Pelanggan</h2>

            <!-- Customer Name -->
            <div class="mb-4">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-600">Nama</label>
                <input type="text" id="name" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary" required>
            </div>

            <!-- Customer Email -->
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium text-gray-600">Email</label>
                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary" required>
            </div>

            <!-- Customer Phone -->
            <div class="mb-4">
                <label for="phone" class="block mb-2 text-sm font-medium text-gray-600">Telepon</label>
                <input type="tel" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary" required>
            </div>

            <!-- Customer Address -->
            <div class="mb-6">
                <label for="address" class="block mb-2 text-sm font-medium text-gray-600">Alamat</label>
                <textarea id="address" name="address" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-brand-primary" required></textarea>
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="w-full px-6 py-3 font-bold text-white transition rounded-md bg-brand-primary hover:bg-brand-primary/90">
                    Buat Pesanan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection