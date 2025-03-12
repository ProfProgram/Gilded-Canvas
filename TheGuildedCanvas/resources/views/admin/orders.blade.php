@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Order Management</h2>

    <!-- Success Message (For Future Use) -->
    <div id="successMessage" class="alert alert-success" style="display:none;">
        Action completed successfully!
    </div>

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
                <th>Total Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
                <tr id="order-{{ $order->order_id }}">
                    <td>#{{ $order->order_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>£{{ number_format($order->total_price, 2) }}</td>

                    <!-- Status Dropdown -->
                    <td>
                        <select class="status-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </td>

                    <!-- Action Buttons -->
                    <td>
                        <button class="update-button">Update</button>
                        <button class="delete-button">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
