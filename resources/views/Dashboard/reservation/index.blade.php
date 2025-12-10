@extends('layouts.dashboard')

@section('header')
    <div class="flex justify-between items-center">
        <h1 class="text-xl font-semibold text-gray-800">Daftar Reservasi</h1>
        <a href="{{ route('Dashboard.reservation.create') }}" class="btn-secondary px-4 py-2 rounded-lg">Tambah Reservasi</a>
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
                    <th class="px-6 py-4 text-left text-white">Nomor Meja</th>
                    <th class="px-6 py-4 text-left text-white">Tanggal Reservasi</th>
                    <th class="px-6 py-4 text-left text-white">Waktu Reservasi</th>
                    <th class="px-6 py-4 text-center text-white">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @php $no = 1; @endphp
                @forelse($reservations as $reservation)
                <tr>
                    <td class="px-6 py-4">{{ $no++ }}</td>
                    <td class="px-6 py-4">{{ $reservation->customer->name ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $reservation->tableRestaurant->table_number ?? '-' }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reservation->reservation_date)->format('d M Y') }}</td>
                    <td class="px-6 py-4">{{ \Carbon\Carbon::parse($reservation->reservation_time)->format('H:i') }}</td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('Dashboard.reservation.edit', $reservation->reservation_id) }}" class="px-3 py-1 bg-yellow-400 text-white rounded-lg hover:bg-yellow-500 transition">Edit</a>
                        <form action="{{ route('Dashboard.reservation.destroy', $reservation->reservation_id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus reservasi ini?')" class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center">Belum ada reservasi.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection
