<!DOCTYPE html>
<html lang="en">
<head>
    <head_text>

        <h1>The Gilded Canvas</h1>


    </head_text>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <title>signup page</title>
    <button class="signup-btn">Login</button>
    <div class="logo">
        <img src="Logo.jpg" alt="gilded canvas Logo" width="120" height="400" />
    </div>

    <link href="{{ asset('css/loginandsignup.css') }}" rel="stylesheet">
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
        <h1>Signup</h1>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-text">
                <label for="Username">Username</label>
                <input type="text" name="name" id="Username" placeholder="create username" />
            </div>



            <div class="form-text">
                <label for="Password"> Password </label>
                <input type="password" name="password" id="Password" placeholder=" Create Password" />
            </div>


            <div class="form-text">
                <label for="Confirm password">Confirm password</label>
                <input type="password" name="password_confirmation" id="Confirm password" placeholder="verify password" />
            </div>


            <div class="form-text">
                <label for="Email">Email</label>
                <input type="Email" name="email" id="Email" placeholder="Enter Email" />
            </div>



            <div class="form-text">
                <label for="PhoneNumber">PhoneNumber</label>
                <input type="number" name="phone_number" id="PhoneNumber" placeholder="Enter PhoneNumber" />
            </div>





            <div class="form-text">
                <label for="options">Select A Role</label>
                <select id="options" name="role">
                    <option value="admin">admin</option>
                    <option value="user">customer</option>
                </select>
            </div>










            <a href="#" class="forgot-details">Already a member?</a>
            <button type="submit" class="login-btn">Signup</button>
        </form>
        <div class="signup-prompt">
            <p>have an account?</p>
            <a href="#" class="signup-link">Login Now</a>
        </div>
    </section>
</main>
</body>
</html>
