@extends('layouts.dashboard')

@section('header')
	<h1 class="text-xl font-semibold text-gray-800">Detail Customer</h1>
@endsection

@section('dashboard-content')
	<div class="bg-white rounded-lg shadow p-6">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
			<div>
				<h3 class="text-sm text-gray-500">Nama</h3>
				<p class="text-lg font-medium">{{ $customer->name }}</p>
			</div>
			<div>
				<h3 class="text-sm text-gray-500">Email</h3>
				<p class="text-lg">{{ $customer->email ?? '-' }}</p>
			</div>
			<div>
				<h3 class="text-sm text-gray-500">Telepon</h3>
				<p class="text-lg">{{ $customer->phone ?? '-' }}</p>
			</div>
			<div class="md:col-span-2">
				<h3 class="text-sm text-gray-500">Alamat</h3>
				<p class="text-lg">{{ $customer->address ?? '-' }}</p>
			</div>
		</div>

		<div class="mt-6 flex justify-end gap-2">
			<a href="{{ route('Dashboard.customer.index') }}" class="px-4 py-2 rounded bg-gray-200">Kembali</a>
			<a href="{{ route('Dashboard.customer.edit', $customer->customer_id) }}" class="px-4 py-2 rounded bg-yellow-400 text-white">Edit</a>
		</div>
	</div>
@endsection
