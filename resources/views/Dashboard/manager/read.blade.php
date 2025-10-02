@extends('Dashboard.layout.master')

@section('content')
<div class="max-w-2xl mx-auto bg-white shadow rounded p-6">
    <h2 class="text-2xl font-bold text-indigo-700 mb-6">Detail Manager</h2>

    <div class="space-y-4">
        <div>
            <span class="font-semibold">Nama:</span>
            <p>{{ $manager->name }}</p>
        </div>

        <div>
            <span class="font-semibold">Email:</span>
            <p>{{ $manager->email }}</p>
        </div>

        <div>
            <span class="font-semibold">Telepon:</span>
            <p>{{ $manager->phone ?? '-' }}</p>
        </div>

        <div>
            <span class="font-semibold">Dibuat pada:</span>
            <p>{{ $manager->created_at->format('d M Y H:i') }}</p>
        </div>

        <div>
            <span class="font-semibold">Terakhir diperbarui:</span>
            <p>{{ $manager->updated_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <div class="mt-6 flex justify-end space-x-2">
        <a href="{{ route('Dashboard.manager.index') }}" 
           class="bg-gray-500 text-white px-4 py-2 rounded">Kembali</a>
        <a href="{{ route('Dashboard.manager.edit', $manager->id) }}" 
           class="bg-yellow-500 text-white px-4 py-2 rounded">Edit</a>
    </div>
</div>
@endsection
