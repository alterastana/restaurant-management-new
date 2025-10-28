@extends('Dashboard.layout.master')
@section('title', 'Update Data Loyalty')
@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-4">Update Data Loyalty</h1>
    <div class="bg-white p-8 rounded-2xl shadow-lg">
        <form action="{{ route('Dashboard.loyalty.update', $loyalty) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label for="customer_id" class="block font-medium text-gray-700">Customer</label>
                    <select name="customer_id" id="customer_id" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ $loyalty->customer_id == $customer->id ? 'selected' : '' }}>
                                {{ $customer->name }} ({{ $customer->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="points" class="block font-medium text-gray-700">Poin</label>
                    <input type="number" name="points" id="points" value="{{ old('points', $loyalty->points) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
                </div>
                <div>
                    <label for="membership_level" class="block font-medium text-gray-700">Level Membership</label>
                    <input type="text" name="membership_level" id="membership_level" value="{{ old('membership_level', $loyalty->membership_level) }}" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm" required>
                </div>
            </div>
            <div class="flex justify-end mt-8">
                <a href="{{ route('Dashboard.loyalty.index') }}" class="py-2 px-6 rounded-lg text-gray-700 bg-gray-200 hover:bg-gray-300 mr-4">Batal</a>
                <button type="submit" class="py-2 px-6 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Update</button>
            </div>
        </form>
    </div>
@endsection