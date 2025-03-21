@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Manage Returns</h2>

    @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Return ID</th>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Requested At</th>
            </tr>
        </thead>
   <tbody>
    @foreach ($returns as $return)
    <tr>
        <td>{{ $return->return_id }}</td>  <!-- Changed from id to return_id -->
        <td>{{ $return->order_id }}</td>
        <td>{{ $return->customer_name }}</td>
        <td>{{ $return->reason }}</td>
        <td>{{ ucfirst($return->status) }}</td>
        <td>{{ $return->created_at }}</td>
    </tr>
    @endforeach
</tbody>

    </table>
</div>
@endsection

