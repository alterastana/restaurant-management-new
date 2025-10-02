@extends('Dashboard.layout.master')

@section('content')
<div class="max-w-3xl p-6 mx-auto bg-white rounded shadow">
    <h2 class="mb-4 text-2xl font-bold text-indigo-700">Update Manager</h2>

    <form action="{{ route('Dashboard.manager.update', $manager->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Nama</label>
            <input type="text" name="name" value="{{ old('name', $manager->name) }}" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Email</label>
            <input type="email" name="email" value="{{ old('email', $manager->email) }}" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Phone</label>
            <input type="text" name="phone" value="{{ old('phone', $manager->phone) }}" 
                class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Password (Kosongkan jika tidak diubah)</label>
            <input type="password" name="password" class="w-full px-3 py-2 border rounded">
        </div>

        <div class="mb-4">
            <label class="block mb-1 font-semibold">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full px-3 py-2 border rounded">
        </div>

        <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded hover:bg-indigo-700">
            Update
        </button>
    </form>
</div>
@endsection
