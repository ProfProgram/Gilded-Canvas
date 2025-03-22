<!DOCTYPE html>
<html lang="en">
<head>
<link
  href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;700&display=swap"
  rel="stylesheet"
/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset('images/TGC-Black-and-Gold.png') }}">
    <title>The Gilded Canvas</title>
    <link rel="stylesheet" href="{{ asset('css/stylesheet.css') }}">

    @yield('styles')
</head>
<body>
    <header>
        <nav id="navbar">
            <a url="/home">
            <img id="navbar-logo" src="{{ asset('images/TGC-Black-and-Gold.png') }}" alt="The Gilded Canvas Logo">
            </a>
            <!-- connected pages -->
            <!-- public links -->
            <a href="/home">Home</a>
            <a href="/product">Products</a>
            <a href="/about-us">About Us</a>
            <a href="/contact-us">Contact Us</a>
            <!-- Logged-in Links -->
            @auth
                <a href="/basket" class="cart-icon">
                    <img src="{{ asset('images/cart-icon.png') }}" alt="Shopping Cart" class="cart-icon-img">
                    <span class="cart-item-count">({{$cartCount}})</span>
                </a>
                <a href="/previous-orders">Previous Orders</a>

                <!-- Role-Specific Links -->
                 <!-- Admin Dropdown Menu -->
                 @if(Auth::user()->role === \App\Enums\UserRole::admin)
                <div class="dropdown">
                    <button class="dropdown-toggle">Admin Panel</button>
                    <div class="dropdown-menu">
                        <a href="{{ route('admin.orders') }}">Order Management</a>
                        <a href="{{ route('admin.inventory') }}">Inventory Management</a>
                        <a href="{{ route('admin.customers') }}">Customer Management</a>
                        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                        <a href="{{ route('admin.returns') }}">Returns Management</a>
                    </div>
                </div>
                @endif
                @if(Auth::user()->role === \App\Enums\UserRole::manager)
                    <a href="{{ route('manager.users') }}">Manage Users</a>
                @endif
                <a href="/account" class="cart-icon">
                    <img src="{{ asset('images/profile.png') }}" alt="Account Centre" class="cart-icon-img">
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline-form">
                    @csrf
                    <button type="submit" class="logout-link">Logout</button>
                </form>
            @endauth
            <!-- guest links -->
            @guest
            <a href="/sign-in">Sign-in</a>
            <a href="/sign-up">Sign-up</a>
            @endguest
        </nav>
    </header>


    <div class="container">
        @yield('content')
    </div>
    <footer style="background-color: #1A1A1A; color: #ffffff; padding: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap;">
        <!-- copyright notice and the year we were established -->

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
                <a href="/about-us" style="color: #ffffff; text-decoration: none;">Learn More</a>
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
                    <img src="{{ asset('images/facebook-logo.png') }}" alt="Facebook" style="width: 30px; height: auto;">
                </a>
                <a href="https://www.instagram.com" target="_blank">
                    <img src="{{ asset('images/instagram-icon.png') }}" alt="Instagram" style="width: 30px; height: auto;">
                </a>
                <a href="https://www.twitter.com" target="_blank">
                    <img src="{{ asset('images/twitter-icon.png') }}" alt="Twitter" style="width: 30px; height: auto;">
                </a>
            </div>
        </div>
    </footer>
    <script rel="script" src="{{ asset('js/js.js') }}"></script>
</body>
</html>
