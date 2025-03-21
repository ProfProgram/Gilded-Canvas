
@extends('layouts.master')




    <!-- Your basket page content -->
@section('content')

@php
$totalPrice = 0;
@endphp
<!-- Main Shopping Cart Section -->
<main class="cart-container">
    @if (session('status'))
    <div class="alert">
        <p class="message">{{ session('status') }}</p>
        <form method="POST" action="{{ url('/close-alert') }}" style="display: inline;">
            @csrf
            <button type="submit" class="close-btn">✖</button>
        </form>
    </div>
    @endif
    <!-- <h1 class="cart-title">Shopping Cart</h1> -->

    @if ($cartItems->isEmpty())
        <!-- Empty Basket Message -->
        <div id="empty-basket-container">
            <h2>Your shopping cart is empty</h2>
            <a href="{{url('product')}}">
                <button class="continue-shopping-button">Continue Shopping</button>
            </a>
        </div>
    @else
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items" id="cart-items">
          <!-- Cart Items -->
<div class="cart-items" id="cart-items">
    @foreach($cartItems as $item)
    <div class="cart-item">
        <div class="product-image">
            <img src="{{ asset('images/products/img-' . $item->product_id . '.png') }}" alt="Gold Leaf Canvas">
        </div>
        <form action="{{ route('basket.update') }}" method="post">
            @csrf
            <input type="hidden" name="id" value="{{ $item->basket_id }}">
            <div class="product-details">
                <h3>{{ $item->product->product_name }}</h3>
                <!-- Remove the description line here -->
                <!-- <p>{{ $item->product->description }}</p> -->
                @if ($item->stock_level > 0)
                <p>Out of Stock. Current stock : {{ $item->stock_level }}</p>
                @endif
                <p>Price: £{{ $item->product->price }}</p>
                <div class="quantity-container">
                    <label for="quantity">Quantity:</label>
                    <input type="number"
                        class="quantity-input"
                        name="quantity"
                        value="{{ $item->quantity }}"
                        min="1"
                        max="15"
                        step="1"
                        data-price="{{ $item->product->price }}">
                </div>
                <button class="update-basket-button">Update Basket</button>
                <a href="{{ url('delete/'.$item->basket_id) }}">
                    <button class="remove-button" type="button">Remove</button>
                </a>
            </div>
        </form>
    </div>
    <hr class="item-divider">
    @php
                    $totalPrice += $item->quantity * $item->product->price;
                    @endphp
                    @endforeach
</div>
     
            </div>
                <!-- Continue Shopping Button Inside the Cart -->
                <div class="continue-shopping">
                    <a href="{{ url('/product')}}">
                        <button class="continue-shopping-button">Continue Shopping</button>
                    </a>
                </div>
            </div>

            <!-- Checkout Section -->
            <form method="GET" action="{{url('/payment')}}">
                @csrf
                <aside class="checkout-container" id="checkout-container">
                    <h2>Estimated Total:</h2>
                    <input type="hidden" name="totalPrice" value="{{$totalPrice}}">
                    <p id="estimated-total" name="total_price" value="{{$totalPrice}}">£{{$totalPrice}}.00</p>
                    @if ($item->stock_level > 0)
                    <button class="checkout-button" type="submit">Checkout</button>
                    @else
                    <button class="checkout-button" disabled>One or more items in basket are out of stock</button>
                    @endif
                </aside>
            </form>
        </div>
    @endif
</main>
<script>
    document.addEventListener("DOMContentLoaded", () => {
    // Function to update the total
    function updateTotal() {
        const quantityInputs = document.querySelectorAll('.quantity-input');
        let total = 0;

        quantityInputs.forEach(input => {
            const price = parseFloat(input.getAttribute('data-price'));
            let quantity = parseInt(input.value) || 0;

            // Calculate total
            total += price * quantity;
        });

        // Update the total display
        const totalDisplay = document.getElementById('estimated-total');
        if (totalDisplay) {
            totalDisplay.textContent = `£${total.toFixed(2)}`;
        }
    }

    // Attach event listeners to quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal); // Attach updateTotal function to input change
    });
});
</script>
@endsection
