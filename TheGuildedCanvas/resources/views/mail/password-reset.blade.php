<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
</head>
<body>
<h1>Password Reset Request</h1>

<p>Hello {{ $name }},</p>

<p>We received a request to reset your password. If you didn't make this request, please ignore this email. Otherwise, you can reset your password using the link below:</p>

<a href="{{ url('/reset-password/{token}', $token) }}">Reset Password</a>

<p>Thank you,<br>
    TheGildedCanvas Team</p>
</body>
</html>
