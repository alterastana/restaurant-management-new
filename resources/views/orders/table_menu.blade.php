{{-- resources/views/orders/table_menu.blade.php --}}
@extends('layouts.app') {{-- ganti sesuai layout utama Anda --}}

@section('title', 'Menu Meja #' . $table->table_number)

@section('content')
<div class="container mt-5">
    <h1>Menu untuk Meja #{{ $table->table_number }}</h1>
    <p>Silakan pilih menu yang ingin dipesan.</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('order.tables.submit', $table->table_id) }}" method="POST">
        @csrf
        <div class="row">
            @foreach($menus as $menu)
                <div class="col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">{{ $menu->name }}</h5>
                            <p class="card-text">Harga: Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                            <div class="mb-2">
                                <label for="quantity_{{ $menu->menu_id }}">Jumlah:</label>
                                <input type="number" name="menu_items[{{ $menu->menu_id }}][quantity]" 
                                       id="quantity_{{ $menu->menu_id }}" 
                                       value="0" min="0" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <input type="hidden" name="table_id" value="{{ $table->table_id }}">
        <input type="hidden" name="restaurant_id" value="{{ $table->restaurant_id }}">
        <button type="submit" class="btn btn-success mt-3">Submit Pesanan</button>
    </form>
</div>
@endsection
