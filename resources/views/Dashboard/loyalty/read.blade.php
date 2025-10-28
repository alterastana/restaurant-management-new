@extends('Dashboard.layout.master')

@section('content')
<div class="container mt-4">
    <h2>Detail Loyalty Member</h2>

    <table class="table table-bordered">
        <tr>
            <th>Loyalty ID</th>
            <td>{{ $loyalty->loyalty_id }}</td>
        </tr>
        <tr>
            <th>Customer ID</th>
            <td>{{ $loyalty->customer_id }}</td>
        </tr>
        <tr>
            <th>Points</th>
            <td>{{ $loyalty->points }}</td>
        </tr>
        <tr>
            <th>Membership</th>
            <td>
                @if($loyalty->points == 0)
                    Non-member
                @elseif($loyalty->points < 100)
                    Silver
                @elseif($loyalty->points < 200)
                    Gold
                @else
                    Platinum
                @endif
            </td>
        </tr>
        <tr>
            <th>Benefit</th>
            <td>
                @if($loyalty->points == 0)
                    Belum dapat benefit
                @elseif($loyalty->points < 100)
                    Diskon 5%
                @elseif($loyalty->points < 200)
                    Diskon 7%
                @else
                    Diskon 9%
                @endif
            </td>
        </tr>
    </table>

    <a href="{{ route('Dashboard.loyalty.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection
