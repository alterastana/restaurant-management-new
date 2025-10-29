@extends('layouts.dashboard')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">Daftar Customer</h1>
@endsection

@section('dashboard-content')
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h2 class="text-lg font-semibold">Daftar Customer</h2>
                <p class="text-sm text-gray-500">Kelola data pelanggan terdaftar di sistem.</p>
            </div>
            <a href="{{ route('Dashboard.customer.create') }}" class="btn-secondary px-4 py-2 rounded-lg">+ Tambah Customer</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead class="bg-brand-primary text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">No</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left">Email</th>
                        <th class="px-4 py-3 text-left">Telepon</th>
                        <th class="px-4 py-3 text-left">Alamat</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y" id="customer-table-body">
                    @include('Dashboard.customer.table')
                </tbody>
            </table>
        </div>

        <div class="mt-4 flex justify-center">
            <button id="show-more-btn" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors" onclick="loadMore()" style="{{ $customers->hasMorePages() ? '' : 'display: none;' }}">
                Tampilkan Lebih Banyak
            </button>
        </div>

        <script>
            function loadMore() {
                const button = document.getElementById('show-more-btn');
                button.disabled = true;
                button.innerText = 'Loading...';

                fetch('{{ route("Dashboard.customer.index") }}?show_more=true', {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    document.getElementById('customer-table-body').innerHTML = html;
                    button.style.display = 'none';
                })
                .catch(error => {
                    console.error('Error:', error);
                    button.disabled = false;
                    button.innerText = 'Tampilkan Lebih Banyak';
                });
            }
        </script>
    </div>
@endsection