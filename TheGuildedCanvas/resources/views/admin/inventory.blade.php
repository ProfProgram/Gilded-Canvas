@extends('layouts.master')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('status'))
    <div class="alert">
        <p class="message">{{ session('status') }}</p>
        <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
            @csrf
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
    @endif
    <div class="container">
        <h1>Inventory Management</h1>
        <table class="table">
            <thead>
            <tr>
                <th>Product Name</th>
                <th>Stock Level</th>
                <th>Stock Incoming</th>
                <th>Stock Outgoing</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($inventory as $item)
                <tr>
                    <td>{{ $item->product->product_name }}</td>
                    <td>
                        <form action="{{ route('admin.inventory.update', $item->inventory_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <input type="number" name="stock_level" value="{{ $item->stock_level }}" class="form-control" style="width: 100px;" required>
                            <button type="submit" class="logout-link">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.inventory.update.incoming', $item->inventory_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <input type="number" name="stock_incoming" value="{{ $item->stock_incoming }}" class="form-control" style="width: 100px;" required>
                            <button type="submit" class="logout-link">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.inventory.update.outgoing', $item->inventory_id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                            <input type="number" name="stock_outgoing" value="{{ $item->stock_outgoing }}" class="form-control" style="width: 100px;" required>
                            <button type="submit" class="logout-link">Update</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('admin.inventory.destroy', $item->inventory_id) }}" method="POST" style="display:inline;">
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
