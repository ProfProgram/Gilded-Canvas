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

    <link rel="stylesheet" href="loginandsignup.css">
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
        <h1>Signup</h1>
        <form>
            <div class="form-text">
                <label for="Username">Username</label>
                <input type="username" id="Username" placeholder="create username" />
            </div>



            <div class="form-text">
                <label for="Password"> Password </label>
                <input type="password" id="Password" placeholder=" Create Password" />
            </div>


            <div class="form-text">
                <label for="Confirm password">Confirm password</label>
                <input type="Confirm password" id="Confirm password" placeholder="verify password" />
            </div>


            <div class="form-text">
                <label for="Email">Email</label>
                <input type="Email" id="Email" placeholder="Enter Email" />
            </div>



            <div class="form-text">
                <label for="PhoneNumber">PhoneNumber</label>
                <input type="PhoneNumber" id="PhoneNumber" placeholder="Enter PhoneNumber" />
            </div>





            <div class="form-text">
                <label for="options">Select A Role</label>
                <select id="options">
                    <option value="option1">Admin</option>
                    <option value="option2">Customer</option>
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
