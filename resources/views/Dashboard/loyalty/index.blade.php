@extends('layouts.dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Data Poin Loyalty</h1>
        <a href="{{ route('Dashboard.loyalty.create') }}" class="btn-secondary px-4 py-2 rounded-lg">Tambah Data</a>
    </div>
@endsection

@section('dashboard-content')
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-brand-primary">
                <tr>
                    <th class="px-6 py-4 text-left text-white">No</th>
                    <th class="px-6 py-4 text-left text-white">Nama Customer</th>
                    <th class="px-6 py-4 text-left text-white">Poin</th>
                    <th class="px-6 py-4 text-left text-white">Level Membership</th>
                    <th class="px-6 py-4 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y" id="loyalty-table-body">
                @include('Dashboard.loyalty.table')
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        <button id="show-more-btn" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors" onclick="loadMore()" style="{{ $rewards->hasMorePages() ? '' : 'display: none;' }}">
            Tampilkan Lebih Banyak
        </button>
    </div>

    <script>
    function loadMore() {
        const button = document.getElementById('show-more-btn');
        button.disabled = true;
        button.innerText = 'Loading...';

        fetch('{{ route("Dashboard.loyalty.index") }}?show_more=true', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('loyalty-table-body').innerHTML = html;
            button.style.display = 'none';
        })
        .catch(error => {
            console.error('Error:', error);
            button.disabled = false;
            button.innerText = 'Tampilkan Lebih Banyak';
        });
    }
    </script>
@endsection