@extends('layouts.dashboard')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">Edit Customer</h1>
@endsection

@section('dashboard-content')
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('Dashboard.customer.update', $customer->customer_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 gap-4">
                <label>
                    <div class="text-sm font-medium text-gray-700">Nama</div>
                    <input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full mt-1 p-2 border rounded" required>
                </label>

                <label>
                    <div class="text-sm font-medium text-gray-700">Email</div>
                    <input type="email" name="email" value="{{ old('email', $customer->email) }}" class="w-full mt-1 p-2 border rounded">
                </label>

                <label>
                    <div class="text-sm font-medium text-gray-700">Telepon</div>
                    <input type="text" name="phone" value="{{ old('phone', $customer->phone) }}" class="w-full mt-1 p-2 border rounded">
                </label>

                <label>
                    <div class="text-sm font-medium text-gray-700">Alamat</div>
                    <textarea name="address" class="w-full mt-1 p-2 border rounded" rows="4">{{ old('address', $customer->address) }}</textarea>
                </label>

                <div class="flex gap-2 justify-end">
                    <a href="{{ route('Dashboard.customer.index') }}" class="px-4 py-2 rounded bg-gray-200">Batal</a>
                    <button type="submit" class="px-4 py-2 rounded btn-primary text-white">Perbarui</button>
                </div>
            </div>
        </form>
    </div>
@endsection
