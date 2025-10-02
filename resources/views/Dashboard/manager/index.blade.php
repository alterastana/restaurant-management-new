@extends('Dashboard.layout.master')

@section('content')
<div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-bold mb-4">Tabel Data Manager</h2>

    <div class="flex justify-between mb-4">
        <input type="text" placeholder="Cari Nama..." class="border px-3 py-2 rounded w-1/3">
        <a href="{{ route('Dashboard.manager.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Tambah Manager</a>
    </div>

    <table class="w-full border text-left">
        <thead class="bg-blue-600 text-white">
            <tr>
                <th class="px-4 py-2">Nama</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Telepon</th>
                <th class="px-4 py-2">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($managers as $manager)
            <tr class="border-b">
                <td class="px-4 py-2">{{ $manager->name }}</td>
                <td class="px-4 py-2">{{ $manager->email }}</td>
                <td class="px-4 py-2">{{ $manager->phone }}</td>
                <td class="px-4 py-2 space-x-2">
                    <a href="{{ route('Dashboard.manager.show', $manager->id) }}" 
                        class="bg-green-600 text-white px-3 py-1 rounded">View</a>
                    <a href="{{ route('Dashboard.manager.edit', $manager->id) }}" class="bg-yellow-500 text-white px-3 py-1 rounded">Edit</a>
                    <form action="{{ route('Dashboard.manager.destroy', $manager->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
