@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Customer Management</h2>

    <!--  Search Form -->
    <form method="GET" action="{{ route('admin.customers') }}" class="filter-form">
        <input type="text" name="search" placeholder="Search by ID or Name" value="{{ request()->search }}" class="filter-input" />
        <button type="submit" class="filter-button">Search</button>
    </form>

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
            @if($customers->isEmpty())
                <tr>
                    <td colspan="5" class="no-results">No customers found.</td>
                </tr>
            @else
                @foreach($customers as $customer)
                    <tr>
                        <td>{{ $customer->user_id }}</td>
                        <td>{{ $customer->name }}</td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone_number ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($customer->created_at)->format('d M Y') }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
