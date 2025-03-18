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

    <div class="container">
        <h1>Inventory Management</h1>

        <!-- Add Product Button -->
        <a href="{{ route('product.create') }}" class="btn btn-warning"
           style="background-color: #d4af37; color: #1A1A1A; padding: 10px 20px;
                  border-radius: 5px; font-weight: bold; text-decoration: none; 
                  display: inline-block; margin-bottom: 20px;">
            + Add Product
        </a>

        <table class="table">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Stock Level</th>
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
                                <button type="submit" class="btn btn-primary">Update</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.inventory.destroy', $item->inventory_id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
