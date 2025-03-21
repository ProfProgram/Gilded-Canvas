@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Manage Returns</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Return ID</th>
                <th>Order ID</th>
                <th>User ID</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Requested At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($returns as $return)
            <tr>
                <td>{{ $return->return_id }}</td>
                <td>{{ $return->order_id }}</td>
                <td>{{ $return->user_id }}</td>
                <td>{{ $return->product_id }}</td>
                <td>{{ $return->quantity }}</td>
                <td>{{ $return->reason }}</td>
                <td>{{ ucfirst($return->status) }}</td>
                <td>{{ $return->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection


