@extends('layouts.master')

@section('content')

<!-- Testing data -->
<!-- {{ $orders }} -->


<main class="orders-container">
    <h1 class="orders-title">Previous Orders</h1>
    <div class="orders-layout">
        <!-- gives message if there are no previous orders -->
        @if ($orders->isEmpty())
            <p style="display: flex; justify-content: center; align-items: center;">You have no previous orders. Would like to see our <a href="/product" style="color: #d4af37; text-decoration: underline; margin-left: 5px">offers</a>?</p>
        @else
            @foreach ($orders->groupBy('order_id') as $orderGroup)
                @foreach ($orderGroup as $order)
                    @if ($loop->first)
                        <div class="order-details">
                            <h3>Order ID: {{$order['order_id']}}</h3>
                            <p>Order Placed: {{$order['order_time']}}</p>
                        </div>
                        <div class="order-status">
                            <p>Order Status: {{$order['status']}}</p>
                        </div>
                    @endif
                    
                    @foreach ($order['products'] as $product)
                    <div class="order-items">
                        <div class="order-item">
                            <div class="product-image">
                                <img src="{{ asset('images/products/img-'.$product['product_id'].'.png') }}" alt="{{$product['product_name']}}">
                            </div>
                            <div class="product-description">
                                <h3>{{$product['product_name']}}</h3>
                                <p>Quantity: {{$product['quantity']}}</p>
                                <p>Total: £{{$product['price_of_order']}}</p>
                            </div>
                            <button class="reorder-button" onclick="window.location.href='{{ url('/product/'.$product['product_name'].'') }}'">Reorder</button>
                            <button class="return-button" 
    onclick="window.location.href='{{ route('return.request', ['order_id' => $order['order_id']]) }}'">
    Request Return
</button>

                        </div>
                    </div>
                    @endforeach
                @endforeach

                <div class="order-footer">
                    <p>Assigned Admin: {{$order['admin_name']}}</p>
                    <p>Total Price: £{{$order['total_price']}}</p>
                </div>
                <hr class="divider">
            @endforeach
        @endif
    </div>
</main>
@endsection
