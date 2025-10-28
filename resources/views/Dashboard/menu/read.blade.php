@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h2>Show Menu Item</h2>
            <a class="btn btn-primary" href="{{ route('menu.index') }}"> Back</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Name:</strong>
                {{ $menu->name }}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Description:</strong>
                {{ $menu->description }}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Price:</strong>
                Rp {{ number_format($menu->price, 2) }}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Stock:</strong>
                {{ $menu->stock }}
            </div>
        </div>
        <div class="col-xs-12">
            <div class="form-group">
                <strong>Restaurant ID:</strong>
                {{ $menu->restaurant_id }}
            </div>
        </div>
    </div>
@endsection