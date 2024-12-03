<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gilded Canvas</title>
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">
    <link rel="script" href="{{ asset('js/js.js') }}">
</head>
<body>
    <header>
        <nav id="navbar">
            <a url="/home">
            <img id="navbar-logo" src="{{ asset('images/TGC-Black-and-Gold.png') }}" alt="The Gilded Canvas Logo">
            </a>
            <!-- connected pages -->
            <a href="/home">Home</a>
            <a href="/product">Products</a>
            <a href="/review">Review</a>
            <a href="/contact-us">Contact Us</a>
            <a href="/payment">Payment</a>
            <a href="/sign-in">Sign-in</a>
            <a href="/sign-up">Sign-up</a>
            <a href="/previous-orders">Previous-Orders</a>
            <a href="/basket" class="cart-icon">
                <img src="Images/cart-icon.png" alt="Shopping Cart" class="cart-icon-img">
            <span class="cart-item-count">(2)</span>
            </a>
        </nav>
    </header>


    <div class="container">
        @yield('content')
    </div>
    <footer style="background-color: #1A1A1A; color: #ffffff; padding: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
        <!-- copywrite notice and the year we were established -->

        <div style="flex: 1; margin-bottom: 15px; min-width: 200px;">
            <p style="color: #d4af37; font-size: 1.2rem; font-weight: bold; margin: 0;">© 2024 The Gilded Canvas</p>
            <p style="color: #d4af37; font-size: 1rem; margin: 0;">All Rights Reserved.</p>
            </div>

        <!-- Middle Section: Quick Links and Contact Information -->
        <div style="flex: 2; margin-bottom: 15px; display: flex; justify-content: space-between; min-width: 400px;">
            <!-- Quick Links -->
            <div style="margin-right: 20px;">
                <h3 style="font-size: 1rem; margin-bottom: 10px;">Quick Links:</h3>
                <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.8;">
                    <li><a href="/home" style="color: #ffffff; text-decoration: none;">Home</a></li>
                    <li><a href="/product" style="color: #ffffff; text-decoration: none;">Products</a></li>
                    <li><a href="/contact-us" style="color: #ffffff; text-decoration: none;">Contact Us</a></li>
                </ul>
            </div>
            <!-- About Us -->
            <div style="margin-right: 20px;">
                <h3 style="font-size: 1rem; margin-bottom: 10px;">About Us:</h3>
                <p style="margin: 0;">Find out more about The Gilded Canvas.</p>
            <a href="about.html" style="color: #ffffff; text-decoration: none;">Learn More</a>
            </div>
            <!-- Contact Information -->
            <div>
                <h3 style="font-size: 1rem; margin-bottom: 10px;">Contact Information:</h3>
                <p style="margin: 0;">Email: <a href="mailto:info@gildedcanvas.com" style="color: #ffffff; text-decoration: none;">info@gildedcanvas.com</a></p>
            </div>
        </div>

        <!-- Right Section: Social Media Links -->
        <div style="text-align: right; margin-bottom: 15px; min-width: 150px;">
            <h3 style="font-size: 1rem; margin-bottom: 10px;">Social Media Links:</h3>
            <div style="display: flex; justify-content: flex-end; gap: 10px;">
                <a href="https://www.facebook.com" target="_blank">
                    <img src="Images/facebook-logo.png" alt="Facebook" style="width: 30px; height: auto;">
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="Images/instagram-icon.png" alt="Instagram" style="width: 30px; height: auto;">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="Images/twitter-icon.png" alt="Twitter" style="width: 30px; height: auto;">
                </a>
            </div>
        </div>
    </footer>
</body>
</html>