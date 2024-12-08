@extends('layouts.app')
<head>
    <head_text>

        <h1>The Gilded Canvas</h1>


    </head_text>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>login page</title>
    <button class="signup-btn">Sign up</button>
    <div class="logo">
        <img src="images/TGC_BLack_and_gold.png" alt="gilded canvas Logo" width="120" height="400" />
    </div>

    <link rel="stylesheet" href="{{ asset('css/loginandsignup.css') }}">
</head>
<body>
<header>


    <nav>

        <a href="{{ route('home') }}">Home</a>
        <a href="{{ route('product') }}">Products</a>
        <a href="{{ route('contact-us') }}">Contact Us</a>
        <a href="{{ route('review') }}">About Us</a>

    </nav>
</header>

<main>
    <section class="login-container">
        <h1>Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-text">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" placeholder="Email" required />
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Password" required />
            </div>
            <a href="#" class="forgot-details">Forgot Details?</a>
            <button type="submit" class="login-btn">Log-In</button>
        </form>
        <div class="signup-prompt">
            <p>Don’t have an account?</p>
            <a href="#" class="signup-link">Sign Up Now</a>
        </div>
    </section>
</main>
</body>
