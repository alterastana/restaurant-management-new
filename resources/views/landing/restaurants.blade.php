@extends('layouts.public')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Choose a Restaurant</h1>
        <a href="/" class="text-sm text-gray-600">Back to Home</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($restorans as $restoran)
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-lg font-semibold">{{ $restoran->name }}</h2>
                @if(isset($restoran->address))
                    <p class="text-sm text-gray-500">{{ \Illuminate\Support\Str::limit($restoran->address, 80) }}</p>
                @endif
                <div class="mt-4">
                    <a href="{{ route('landing.restoran.show', $restoran->restaurant_id) }}" class="inline-block px-4 py-2 bg-brand-primary text-white rounded">View Menu</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
