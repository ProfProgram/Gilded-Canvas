<head>
    <head_text>

        <h1>The Gilded Canvas</h1>


    </head_text>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>login page</title>
    <button class="signup-btn">Sign up</button>
    <div class="logo">
        <img src="Logo.jpg" alt="gilded canvas Logo" width="120" height="400" />
    </div>

    <link rel="stylesheet" href="{{ asset('css/loginandsignup.css') }}">
</head>
<body>
<header>


    <nav>

        <a href="index.html">Home</a>
        <a href="products.html">Products</a>
        <a href="contact.html">Contact Us</a>
        <a href="about.html">About Us</a>

    </nav>
</header>

<main>
    <section class="login-container">
        <h1>Login</h1>
        <form>
            <div class="form-text">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Username" />
            </div>
            <div class="form-text">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Password" />
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
