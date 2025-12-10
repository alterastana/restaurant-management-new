@extends('layouts.public')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-4xl font-bold text-center text-gray-800 mb-8">Our Menus</h1>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($menus as $menu)
            <div class="bg-white rounded-lg shadow-md p-6 flex flex-col">
                <h3 class="text-xl font-semibold text-gray-900">{{ $menu->name }}</h3>
                <p class="mt-2 text-gray-600 flex-grow">{{ $menu->description }}</p>
                <p class="mt-4 text-lg font-bold text-green-600">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
            </div>
        @empty
            <p class="text-center text-gray-500 col-span-full">No menus available at the moment.</p>
        @endforelse
    </div>
</div>
@endsection