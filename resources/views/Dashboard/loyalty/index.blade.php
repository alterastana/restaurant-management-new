@extends('Dashboard.layout.master')

@section('content')
<div class="container">
    <h3>Daftar Loyalty Member</h3>
    <a href="{{ route('Dashboard.loyalty.create') }}" class="btn btn-primary mb-3">+ Tambah Member</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer ID</th>
                <th>Points</th>
                <th>Membership</th>
                <th>Benefit</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($loyalties as $loyalty)
                <tr>
                    <td>{{ $loyalty->loyalty_id }}</td>
                    <td>{{ $loyalty->customer_id }}</td>
                    <td>{{ $loyalty->points }}</td>
                    <td>{{ $loyalty->membership_level }}</td>
                    <td>
                        @php
                            if ($loyalty->membership_level == 'Silver') $benefit = '5% Diskon';
                            elseif ($loyalty->membership_level == 'Gold') $benefit = '7% Diskon';
                            elseif ($loyalty->membership_level == 'Platinum') $benefit = '9% Diskon';
                            else $benefit = 'Belum Member';
                        @endphp
                        {{ $benefit }}
                    </td>
                    <td>
                        <a href="{{ route('Dashboard.loyalty.edit', $loyalty->loyalty_id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('Dashboard.loyalty.destroy', $loyalty->loyalty_id) }}" method="POST" style="display:inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Belum ada data member</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
