
@extends('layouts.master')

@section('content')

@php
$totalPrice = 0;
@endphp
<!-- Main Shopping Cart Section -->
<main class="cart-container">
        <h1 class="cart-title">Shopping Cart</h1>
        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-items" id="cart-items">
                <div class="cart-item">
                @foreach($cartItems as $item)
                    <div class="product-image">
                        <img src="{{ asset('images/openart-image_'. $item->product_id .'.jpg')}}" alt="Gold Leaf Canvas">
                    </div>
                    <div class="product-details">
                        <h3>{{$item->product->product_name}}</h3>
                        <p>{{$item->product->description}}</p>
                        <p>Price: {{$item->product->price}}</p>
                        <div class="quantity-container">
                            <label for="quantity">Quantity:</label>
                            <input type="number" class="quantity-input" value="{{$item->quantity}}" min="1" max="15" step="1" data-price="{{$item->product->price}}">
                        </div>
                    </div>
                    <a href="{{url('delete/'.$item->basket_id)}}">
                        <button class="remove-button">Remove</button>
                    </a>
                </div>
                @php
                $totalPrice += $item->quantity * $item->product->price;
                @endphp
                @endforeach
            </div>
                <!-- Continue Shopping Button Inside the Cart -->
                <div class="continue-shopping">
                    <a href="{{ url('/product')}}">
                        <button class="continue-shopping-button">Continue Shopping</button>
                    </a>
                </div>
            </div>

            <!-- Checkout Section -->
            <aside class="checkout-container" id="checkout-container">
                <h2>Estimated Total:</h2>
                <p id="estimated-total">£{{$totalPrice}}.00</p>
                <a href="{{ url('payment/'. $totalPrice)}}">
                    <button class="checkout-button">Checkout</button>
                </a>
                </aside>
        </div>
    </main>

    <!-- Empty Basket Message -->
    <div id="empty-basket-container" style="display: none;">
        <h2>Your shopping cart is empty</h2>
        <button class="continue-shopping-button">Continue Shopping</button>
    </div>
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

    // Check if the cart is empty
    function checkIfCartIsEmpty() {
        const cartItems = document.querySelectorAll('.cart-item');
        const emptyBasketContainer = document.getElementById('empty-basket-container');
        const cartItemsContainer = document.getElementById('cart-items');
        const checkoutContainer = document.querySelector('.checkout-container');
        const cartTitle = document.querySelector('.cart-title');

        if (cartItems.length === 0) {
            emptyBasketContainer.style.display = 'flex'; // Show empty cart message
            cartItemsContainer.style.display = 'none'; // Hide cart items
            if (checkoutContainer) checkoutContainer.style.display = 'none'; // Hide checkout section
            if (cartTitle) cartTitle.style.display = 'none'; // Hide cart title
        } else {
            emptyBasketContainer.style.display = 'none'; // Hide empty cart message
            cartItemsContainer.style.display = 'block'; // Show cart items
            if (checkoutContainer) checkoutContainer.style.display = 'block'; // Show checkout
            if (cartTitle) cartTitle.style.display = 'block'; // Show cart title
        }
    }

    // Handle removing a cart item
    function removeCartItem(event) {
        const cartItem = event.target.closest('.cart-item'); // Find the closest cart item
        if (cartItem) {
            cartItem.remove(); // Remove the item
            updateTotal(); // Update the total price
            updateBasketCount(); // Update the basket count
            checkIfCartIsEmpty(); // Check if the cart is empty
        }
    }
    

    // Attach event listeners to quantity inputs
    const quantityInputs = document.querySelectorAll('.quantity-input');
    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal); // Attach updateTotal function to input change
    });

    // Attach event listeners to remove buttons
    document.querySelectorAll('.remove-button').forEach(button => {
        button.addEventListener('click', removeCartItem);
    });

    // Initial check for empty cart
    checkIfCartIsEmpty();
});
//this function ensures the number of items in the basket dynamically updates
function updateBasketCount() {
    const itemCount = document.querySelectorAll('.cart-item').length; // Count items in the cart
    const cartItemCount = document.querySelector('.cart-item-count');
    if (cartItemCount) {
        cartItemCount.textContent = `(${itemCount})`; // Update the count dynamically
    }
}

// Call this function whenever the cart is updated
updateBasketCount();
</script>
@endsection
