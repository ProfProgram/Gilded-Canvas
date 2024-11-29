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
    const itemCount = document.querySelectorAll('.cart-item').length;
    const cartIcon = document.querySelector('.cart-icon a');
    if (cartIcon) {
        cartIcon.textContent = `🛒 (${itemCount})`;
    }
}
