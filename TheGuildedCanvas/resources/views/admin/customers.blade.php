@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Customer Management</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone Number</th> 
                <th>Registered Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->user_id }}</td> 
                    <td>{{ $customer->name }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->phone_number ?? 'N/A' }}</td> 
                    <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
