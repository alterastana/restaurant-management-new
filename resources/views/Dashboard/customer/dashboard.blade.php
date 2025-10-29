@extends('layouts.dashboard')

@section('header')
    <h1 class="text-xl font-semibold text-gray-800">Customer Dashboard</h1>
@endsection

@section('dashboard-content')
<div class="container">
    <div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold mb-4">Choose a Restaurant</h2>
        <div class="card-grid">
            @foreach(\App\Models\Restoran::orderBy('name')->get() as $restoran)
                <div class="card">
                    <div class="card-body">
                        <div class="card-title">{{ $restoran->name }}</div>
                        @if($restoran->address)
                            <div class="card-sub">{{ \Illuminate\Support\Str::limit($restoran->address, 80) }}</div>
                        @endif
                        <div class="card-cta">
                            <a href="{{ route('landing.restoran.show', $restoran->restaurant_id) }}" class="btn-primary">View Menu</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
