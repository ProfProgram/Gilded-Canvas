@extends('layouts.app')

@section('content')
    <!-- Header Section -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
    <header class="header">

        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ asset('images/TGC_Black_and_Gold.png') }}" alt="The Gilded Canvas Logo">
            </a>
        </div>

        <nav>
            <ul>
                <!-- Public links -->
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('contact-us') }}">Contact</a></li>


                @auth
                    <!-- Links for logged-in users -->
                    <li><a href="{{ route('basket') }}">Basket</a></li>
                    <li><a href="{{ route('payment') }}">Payment</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit">Logout</button>
                        </form>
                    </li>

                    <!-- Admin links -->
                    @if(Auth::user()->role === 'admin')
                        <li><a href="{{ route('admin') }}">Admin Panel</a></li>
                    @endif
                @endauth
            </ul>
        </nav>
        @guest
        <div class="user-actions">
            <a href="{{ url('sign-up') }}" class="nav-btn">Sign Up</a>
            <a href="{{ url('sign-in') }}" class="nav-btn">Log In</a>
        </div>
        @endguest


        <form action="{{ route('search') }}" method="GET">
            <input type="text" name="query" placeholder="Search for products">
            <button type="submit">Search</button>
        </form>

        @auth
        <div class="cart-icon">
            <a href="{{ url('cart') }}" class="btn">🛒 (2)</a>
        </div>
        @endauth
    </header>

    <!-- Hero Section -->
    <section class="hero" id="home">
        <h1>Welcome to The Gilded Canvas</h1>
        <p>Where art meets elegance. Discover unique and timeless pieces crafted for the discerning collector.</p>
        <a href="#products" class="btn">Shop Now</a>
    </section>

    <!-- Product Slider Section -->
    <section class="products" id="products">
        <h2>Featured Products</h2>
        <div class="slider">
            <div class="slider-track">
                <!-- Product 1: Gilded Frame Art -->
                @foreach($products as $product)
                    <a href="{{ route('product.show', ['id' => $product->product_id]) }}" class="product-slide">
                        <img src="{{ asset($product->image_path) }}" alt="{{ $product->caption }}">
                        <p>{{ $product->name }}</p>
                        <p>{{ $product->caption }}</p>
                        <p>{{ $product->description }}</p>
                        <p class="price">£{{ $product->price }}</p>
                        <button class="btn">Add to Cart</button>
                    </a>
                @endforeach


            </div>
            <button class="slider-btn prev-btn">❮</button>
            <button class="slider-btn next-btn">❯</button>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
        <div class="footer-contact">
            <p>Email: <a href="mailto:info@gildedcanvas.com">info@gildedcanvas.com</a></p>
            <p>Phone: +44 (206) 329-4552</p>
        </div>
        <div class="footer-social">
            <a href="https://www.facebook.com" target="_blank">
                <img src="{{ asset('images/facebook-white.png') }}" alt="Facebook Logo">
            </a>
            <a href="https://www.instagram.com" target="_blank">
                <img src="{{ asset('images/instagram-white.png') }}" alt="Instagram Logo">
            </a>
            <a href="https://www.twitter.com" target="_blank">
                <img src="{{ asset('images/twitter-x-white.png') }}" alt="Twitter Logo">
            </a>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="{{ asset('resources/js/script.js') }}"></script>
@endsection
