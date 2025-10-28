@extends('Dashboard.layout.master')
@section('title', 'Data Poin Loyalty')
@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Data Poin Loyalty Customer</h1>
        <a href="{{ route('Dashboard.loyalty.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Tambah Data</a>
    </div>
    
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <div class="bg-white rounded-2xl shadow-lg overflow-x-auto">
        <table class="min-w-full">
            <thead class="bg-indigo-600">
                <tr>
                    <th class="px-6 py-4 text-left text-white">Nama Customer</th>
                    <th class="px-6 py-4 text-left text-white">Poin</th>
                    <th class="px-6 py-4 text-left text-white">Level Membership</th>
                    <th class="px-6 py-4 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse($rewards as $data)
                    <tr class="hover:bg-gray-50">
                        {{-- INI BAGIAN YANG DIUBAH --}}
                        <td class="px-6 py-4 font-medium">{{ $data->customer->name ?? 'Customer Dihapus' }}</td>
                        <td class="px-6 py-4">{{ number_format($data->points) }}</td>
                        <td class="px-6 py-4">{{ $data->membership_level }}</td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="{{ route('Dashboard.loyalty.edit', $data) }}" class="py-2 px-3 bg-yellow-500 text-white rounded">Edit</a>
                                <form action="{{ route('Dashboard.loyalty.destroy', $data) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="py-2 px-3 bg-red-500 text-white rounded">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center py-12">Belum ada data poin.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection