@extends('layouts.master')

@section('content')
<div class="container">
    <h2 class="page-title">Returns Management</h2>

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
                <th>Actions</th>
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
                <td>
                    <!-- Approve Return -->
                    <!-- Remove approve button if status is approved. This stops admins from being able to easily spam the button, increasing the stock incoming infinitely -->
                    @if ($return->status !== 'approved')
                    <form action="{{ route('admin.returns.updateStatus', $return->return_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                    </form>
                    @endif
                    <!-- Deny Return -->
                    <form action="{{ route('admin.returns.updateStatus', $return->return_id) }}" method="POST" style="display:inline;">
                        @csrf
                        <input type="hidden" name="status" value="denied">
                        <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                    </form>

                    <!-- Delete Return -->
                    <form action="{{ route('admin.returns.delete', $return->return_id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection



