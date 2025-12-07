@extends('layouts.public')

@section('content')
<div class="container py-12 mx-auto">
    <div class="max-w-2xl p-8 mx-auto bg-white rounded-lg shadow-md text-center">
        <h1 class="mb-6 text-2xl font-bold text-gray-800">Pembayaran berhasil</h1>

        <p class="text-gray-600 mb-6">
            Terima kasih, Pesanan kamu sudah diterima.
        </p>

        <p class="mt-8 text-gray-500">Silakan menunggu sebentar.</p>

        <a href="{{ route('landing.welcome') }}" 
           class="mt-6 inline-block px-6 py-3 font-bold text-white bg-green-600 rounded-md hover:bg-green-700">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
