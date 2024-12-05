<!DOCTYPE html>
<html>
<head>
    <title>Verify Your Email</title>
</head>
<body>
    <h1>Hello, {{$name}}</h1>

    <p>Thank you for registering. Please click the link below to verify your email address and complete your registration:</p>

    <a href="{{ route('email.verify', ['email' => $email]) }}">Verify Email</a>

    <p>If you did not create an account, no further action is required.</p>

    <p>Regards,<br>TheGildedCanvas Team</p>
</body>
</html>
