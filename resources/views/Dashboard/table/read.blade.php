@extends('layouts.dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Manajemen Meja</h1>
        <a href="{{ route('Dashboard.table.create') }}" class="btn-secondary px-4 py-2 rounded-lg">Tambah Meja</a>
    </div>
@endsection

@section('dashboard-content')
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg">
        <table class="min-w-full">
            <thead class="bg-brand-primary">
                <tr>
                    <th class="px-6 py-4 text-left text-white">Nomor Meja</th>
                    <th class="px-6 py-4 text-left text-white">Restoran</th>
                    <th class="px-6 py-4 text-left text-white">Kapasitas</th>
                    <th class="px-6 py-4 text-left text-white">Status</th>
                    <th class="px-6 py-4 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y" id="table-body">
                @include('Dashboard.table.table')
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        <button id="show-more-btn" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors" onclick="loadMore()" style="{{ $tables->hasMorePages() ? '' : 'display: none;' }}">
            Tampilkan Lebih Banyak
        </button>
    </div>

    <script>
    function confirmDelete(tableId) {
        if (confirm('Yakin ingin menghapus meja ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ url("/Dashboard/table") }}/' + tableId;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    function loadMore() {
        const button = document.getElementById('show-more-btn');
        button.disabled = true;
        button.innerText = 'Loading...';

        fetch('{{ route("Dashboard.table.index") }}?show_more=true', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            document.getElementById('table-body').innerHTML = html;
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