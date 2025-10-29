@extends('Dashboard.layout.master')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-brand-primary">Admin Dashboard</h1>
    <p class="mt-1 text-brand-text">Welcome, {{ Auth::user()->name }}. You have full access to the system.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('Dashboard.users.index') }}" class="card p-6 rounded-2xl">
            <h3 class="text-xl font-bold text-brand-primary">User Management</h3>
            <p class="text-sm text-brand-text mt-1">Add, edit, or remove user accounts.</p>
        </a>
        <a href="{{ route('Dashboard.restoran.index') }}" class="card p-6 rounded-2xl">
            <h3 class="text-xl font-bold text-brand-primary">Restaurant Management</h3>
            <p class="text-sm text-brand-text mt-1">Manage all restaurant data.</p>
        </a>
    </div>
@endsection