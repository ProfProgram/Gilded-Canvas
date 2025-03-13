@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Order Management</h2>

    <!-- Success Message -->
    @if(session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Filter/Search Form -->
    <form method="GET" action="{{ route('admin.orders') }}" class="filter-form">
        <input type="text" name="search" placeholder="Search Order ID or Customer Name" class="filter-input" />
        <select name="status_filter" class="filter-select">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="shipped">Shipped</option>
            <option value="delivered">Delivered</option>
            <option value="cancelled">Cancelled</option>
        </select>
        <button type="submit" class="filter-button">Filter</button>
    </form>

    <!-- Order Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Product Name</th>
                <th>Product ID</th>
                <th>Quantity</th>
                <th>Price of Order</th>
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr>
                    <td>#{{ $order->order_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->product_id }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>£{{ number_format($order->price_of_order, 2) }}</td>
                    <td>£{{ number_format($order->total_price, 2) }}</td>

                    <!-- Status Update Form -->
                    <td>
                        <form action="{{ route('admin.orders.update', $order->order_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <select name="status" class="status-select">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            <button type="submit" class="logout-link">Update</button>
                        </form>
                    </td>

                    <!-- Delete Order Form -->
                    <td>
                        <form action="{{ route('admin.orders.destroy', $order->order_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="logout-link">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
