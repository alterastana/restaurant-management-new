@extends('Dashboard.layout.master')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="mt-1 text-gray-600">Selamat datang, {{ Auth::user()->name }}. Anda memiliki akses penuh terhadap sistem.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('Dashboard.users.index') }}" class="block p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <h3 class="text-xl font-bold text-gray-800">Manajemen User</h3>
            <p class="text-sm text-gray-500 mt-1">Tambah, edit, atau hapus akun pengguna.</p>
        </a>
        <a href="{{ route('Dashboard.restoran.index') }}" class="block p-6 bg-white rounded-2xl shadow-lg hover:shadow-xl transition-shadow duration-300 transform hover:-translate-y-1">
            <h3 class="text-xl font-bold text-gray-800">Manajemen Restoran</h3>
            <p class="text-sm text-gray-500 mt-1">Kelola semua data restoran.</p>
        </a>
    </div>
@endsection