@extends('Dashboard.layout.master')

@section('content')
<div class="p-6 bg-gray-100 min-h-screen">

    {{-- HEADER --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Menu Restoran</h1>
        <a href="{{ route('Dashboard.menu.create') }}"
           class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md shadow">
            Tambah Menu
        </a>
    </div>

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
            <thead class="bg-blue-600 text-white">
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
            <tbody>
                @forelse ($menus as $index => $menu)
                    <tr class="border-b hover:bg-gray-50">
                        <td class="py-3 px-4">{{ $index + 1 }}</td>
                        <td class="py-3 px-4 font-semibold">{{ $menu->name }}</td>
                        <td class="py-3 px-4 text-gray-700">{{ $menu->description }}</td>
                        <td class="py-3 px-4">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>
                        <td class="py-3 px-4">{{ $menu->stock }}</td>
                        <td class="py-3 px-4">{{ $menu->restaurant_id }}</td>
                        <td class="py-3 px-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- VIEW --}}
                                <a href="{{ route('Dashboard.menu.show', $menu->menu_id) }}"
                                   class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-center">
                                    View
                                </a>

                                {{-- EDIT --}}
                                <a href="{{ route('Dashboard.menu.edit', $menu->menu_id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-center">
                                    Edit
                                </a>

                                {{-- DELETE --}}
                                <form action="{{ route('Dashboard.menu.destroy', $menu->menu_id) }}"
                                      method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus menu ini?')"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-center">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-gray-500">
                            Tidak ada data menu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

{{-- SCRIPT FILTER PENCARIAN --}}
<script>
document.getElementById('searchBox').addEventListener('keyup', function() {
    const value = this.value.toLowerCase();
    const rows = document.querySelectorAll('#menuTable tbody tr');

    rows.forEach(row => {
        const name = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        row.style.display = name.includes(value) ? '' : 'none';
    });
});
</script>
@endsection
