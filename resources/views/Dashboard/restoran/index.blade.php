@extends('Dashboard.layout.master')

@section('title', 'Manajemen Restoran')

@section('content')
    {{-- Header Halaman --}}
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Manajemen Restoran</h1>
            <p class="mt-1 text-gray-600">Kelola semua data restoran Anda dari sini.</p>
        </div>
        
        @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
            <a href="{{ route('Dashboard.restoran.create') }}" class="mt-4 sm:mt-0 inline-flex items-center px-4 py-2 btn-secondary text-white text-sm font-medium rounded-lg shadow-lg focus-brand">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6-0H6"></path></svg>
                <span>Tambah Restoran</span>
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4 rounded-r-lg">
            <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    {{-- Tabel Data --}}
    <div class="overflow-x-auto bg-white rounded-2xl shadow-lg">
        <table class="min-w-full">
            {{-- =================================== --}}
            {{--       HEADER TABEL BIRU          --}}
            {{-- =================================== --}}
            <thead class="bg-brand-primary">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Nama & Email</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Alamat</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($restorans as $restoran)
                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $restoran->name }}</div>
                            <div class="text-xs text-gray-500">{{ $restoran->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $restoran->address }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ $restoran->phone }}</td>
                        <td class="px-6 py-4 text-center">
                            
                            {{-- =================================== --}}
                            {{--    TOMBOL-TOMBOL BERWARNA SOLID   --}}
                            {{-- =================================== --}}
                            <div class="flex justify-center items-center space-x-2">
                                
                                {{-- Tombol Lihat Detail (Hijau) --}}
                                <a href="{{ route('Dashboard.restoran.show', $restoran) }}" class="p-2 rounded-md bg-green-500 hover:bg-green-600 transition-colors" title="Lihat Detail">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>

                                {{-- Tombol Edit (Kuning) --}}
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('manager'))
                                    <a href="{{ route('Dashboard.restoran.edit', $restoran) }}" class="p-2 rounded-md bg-yellow-500 hover:bg-yellow-600 transition-colors" title="Edit">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </a>
                                @endif

                                {{-- Tombol Hapus (Merah) --}}
                                @if(auth()->user()->hasRole('admin'))
                                    <form action="{{ route('Dashboard.restoran.destroy', $restoran) }}" method="POST" onsubmit="return confirm('Anda yakin ingin menghapus {{ $restoran->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 rounded-md bg-red-500 hover:bg-red-600 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-12">Tidak Ada Data Restoran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($restorans->hasPages())
        <div class="mt-6">{{ $restorans->links() }}</div>
    @endif
@endsection