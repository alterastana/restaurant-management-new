@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-lg font-bold">Daftar Meja Restoran</h2>
        <a href="{{ route('Dashboard.table.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            + Tambah Meja
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <table class="w-full border border-gray-200 rounded">
        <thead class="bg-gray-100 text-left">
            <tr>
                <th class="px-4 py-2 border">ID</th>
                <th class="px-4 py-2 border">Restoran</th>
                <th class="px-4 py-2 border">Nomor Meja</th>
                <th class="px-4 py-2 border">Kapasitas</th>
                <th class="px-4 py-2 border">Status</th>
                <th class="px-4 py-2 border text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tables as $table)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $table->table_id }}</td>
                    <td class="px-4 py-2 border">{{ $table->restaurant->name ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $table->table_number }}</td>
                    <td class="px-4 py-2 border">{{ $table->capacity }}</td>
                    <td class="px-4 py-2 border capitalize">{{ $table->status }}</td>
                    <td class="px-4 py-2 border text-center flex justify-center space-x-3">

                        <!-- Lihat -->
                        <a href="{{ route('Dashboard.table.show', $table->table_id) }}" 
                           class="bg-green-500 hover:bg-green-600 text-white p-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7
                                         -1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </a>

                        <!-- Edit -->
                        <a href="{{ route('Dashboard.table.edit', $table->table_id) }}" 
                           class="bg-yellow-400 hover:bg-yellow-500 text-white p-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                 viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                      d="M11 4h2m2 0h.01M12 20h.01M4 12h.01M20 12h.01M7.757 7.757l8.486 8.486
                                         M16.243 7.757l-8.486 8.486" />
                            </svg>
                        </a>

                        <!-- Hapus -->
                        <form action="{{ route('Dashboard.table.destroy', $table->table_id) }}" 
                              method="POST" class="inline-block" 
                              onsubmit="return confirm('Yakin hapus meja ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white p-2 rounded-lg transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" 
                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                             a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                             M1 7h22M10 3h4a1 1 0 011 1v1H9V4
                                             a1 1 0 011-1z" />
                                </svg>
                            </button>
                        </form>

                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-gray-500">
                        Belum ada data meja.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection