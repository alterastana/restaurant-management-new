@extends('Dashboard.layout.master')

@section('content')
<div class="container mt-4">
    <h2>Update Poin Loyalty</h2>

    @if ($errors->any())
    <div class="alert alert-danger mb-4">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('Dashboard.loyalty.update', $loyalty->loyalty_id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Customer ID</label>
            <input type="number" class="form-control" name="customer_id" value="{{ $loyalty->customer_id }}" readonly>
        </div>

        <div class="mb-3">
            <label class="form-label">Points</label>
            <input type="number" class="form-control" name="points" value="{{ $loyalty->points }}" required>
        </div>

        <button type="submit" class="btn btn-success">Update</button>
        <a href="{{ route('Dashboard.loyalty.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
