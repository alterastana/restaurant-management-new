@extends('layouts.dashboard')

@section('header')
<div class="flex justify-between items-center">
    <h1 class="text-xl font-semibold text-gray-800">Daftar Menu Restoran</h1>
    <a href="{{ route('Dashboard.menu.create') }}"
       class="btn-secondary px-4 py-2 rounded-lg">
        Tambah Menu
    </a>
</div>
@endsection

@section('dashboard-content')
<div class="bg-white rounded-lg shadow-sm">

    {{-- SEARCH BOX --}}
    <div class="mb-4">
        <input type="text"
               id="searchBox"
               class="w-full md:w-1/2 p-2 border border-gray-300 rounded-md"
               placeholder="Cari Nama Menu...">
    </div>

    {{-- TABLE --}}
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="w-full border-collapse" id="menuTable">
            <thead class="bg-brand-primary text-white">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Nama Menu</th>
                    <th class="py-3 px-4 text-left">Deskripsi</th>
                    <th class="py-3 px-4 text-left">Harga</th>
                    <th class="py-3 px-4 text-left">Stok</th>
                    <th class="py-3 px-4 text-left">Restaurant ID</th>
                    <th class="py-3 px-4 text-center w-48">Aksi</th>
                </tr>
            </thead>
            <tbody id="menu-table-body">
                @include('Dashboard.menu.table')
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-center">
        <button id="show-more-btn" class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors" onclick="loadMore()" style="{{ $menus->hasMorePages() ? '' : 'display: none;' }}">
            Tampilkan Lebih Banyak
        </button>
    </div>
</div>

{{-- SCRIPT FILTER PENCARIAN DAN SHOW MORE --}}
<script>
let searchTimeout;
document.getElementById('searchBox').addEventListener('keyup', function() {
    const button = document.getElementById('show-more-btn');
    const value = this.value.toLowerCase();
    
    clearTimeout(searchTimeout);
    searchTimeout = setTimeout(() => {
        const rows = document.querySelectorAll('#menuTable tbody tr');
        if (value === '') {
            rows.forEach(row => row.style.display = '');
            if (button) button.style.display = '';
            return;
        }

        rows.forEach(row => {
            const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
            row.style.display = name.includes(value) ? '' : 'none';
        });
        
        if (button) button.style.display = 'none';
    }, 300);
});

function loadMore() {
    const button = document.getElementById('show-more-btn');
    button.disabled = true;
    button.innerText = 'Loading...';

    fetch('{{ route("Dashboard.menu.index") }}?show_more=true', {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.text())
    .then(html => {
        document.getElementById('menu-table-body').innerHTML = html;
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
