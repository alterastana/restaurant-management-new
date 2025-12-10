{{-- resources/views/orders/tables.blade.php --}}
@extends('layouts.app') {{-- ganti dengan layout utama kamu jika berbeda --}}

@section('title', 'Pilih Meja')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Pilih Meja</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($tables->isEmpty())
        <p>Tidak ada meja tersedia saat ini.</p>
    @else
        <div class="row">
            @foreach($tables as $table)
                <div class="col-md-3 mb-3">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Meja #{{ $table->table_number }}</h5>
                            <p>Status: 
                                @if($table->status === 'available')
                                    <span class="text-success">Tersedia</span>
                                @else
                                    <span class="text-danger">Terisi</span>
                                @endif
                            </p>
                            @if($table->status === 'available')
                                <a href="{{ route('order.tables.menu', $table->table_id) }}" class="btn btn-primary">
                                    Pilih Meja
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
