@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">{{ $restoran->name }}</h1>
        <a href="{{ route('landing.restaurants') }}" class="text-sm text-gray-600">Back to Restaurants</a>
    </div>

    @if($restoran->description)
        <p class="mb-6 text-gray-600">{{ $restoran->description }}</p>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($menus as $menu)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold">{{ $menu->name }}</h3>
                <p class="text-sm text-gray-500 mt-2">{{ \Illuminate\Support\Str::limit($menu->description, 120) }}</p>
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-lg font-semibold">Rp {{ number_format($menu->price, 0, ',', '.') }}</div>
                    <a href="#" class="px-3 py-1 bg-brand-primary text-white rounded">Order</a>
                </div>
            </div>
        @empty
            <div class="col-span-3 text-center text-gray-500">No menu available for this restaurant.</div>
        @endforelse
    </div>
</div>
@endsection
