@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Order Management</h2>

    <!-- Success Message -->
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
                <tr id="order-{{ $order->order_id }}">
                    <td>#{{ $order->order_id }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->product_name }}</td>
                    <td>{{ $order->product_id }}</td>
                    <td>{{ $order->quantity }}</td>
                    <td>£{{ number_format($order->price_of_order, 2) }}</td>
                    <td>£{{ number_format($order->total_price, 2) }}</td>

                    <!-- Status Dropdown -->
                    <td>
                        <select id="status-{{ $order->order_id }}" class="status-select">
                            <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </td>

                    <!-- Action Buttons -->
                    <td>
                        <button class="update-button" onclick="updateOrder({{ $order->order_id }})">Update</button>
                        <button class="delete-button" onclick="deleteOrder({{ $order->order_id }})">Delete</button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function updateOrder(orderId) {
        let statusDropdown = document.getElementById(`status-${orderId}`);
        let newStatus = statusDropdown.value;

        fetch(`/admin/orders/${orderId}/update`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: newStatus })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let successMessage = document.getElementById("successMessage");
                successMessage.textContent = data.message;
                successMessage.style.display = "block";

                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 3000);
            } else {
                alert('Failed to update order status.');
            }
        })
        .catch(error => alert('Error: ' + error));
    }

    function deleteOrder(orderId) {
        if (!confirm("Are you sure you want to delete this order?")) {
            return;
        }

        fetch(`/admin/orders/${orderId}/delete`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.getElementById(`order-${orderId}`).remove();
                let successMessage = document.getElementById("successMessage");
                successMessage.textContent = "Order deleted successfully!";
                successMessage.style.display = "block";

                setTimeout(() => {
                    successMessage.style.display = "none";
                }, 3000);
            } else {
                alert('Failed to delete order.');
            }
        })
        .catch(error => alert('Error: ' + error));
    }
</script>
@endsection
