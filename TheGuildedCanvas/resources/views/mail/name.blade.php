<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .email-header {
            background-color: #000000; /* Black */
            color: #ffd700; /* Gold */
            text-align: center;
            padding: 20px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        .email-body {
            padding: 20px;
            color: #333333;
        }
        .email-body p {
            font-size: 16px;
            line-height: 1.5;
        }
        .email-body a {
            display: inline-block;
            margin: 20px 0;
            padding: 12px 24px;
            background-color: #ffd700; /* Gold */
            color: #000000; /* Black */
            text-decoration: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: bold;
        }
        .email-body a:hover {
            background-color: #e6b800; /* Darker gold on hover */
        }
        .email-footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f4f4;
            color: #777777;
            font-size: 14px;
        }
        .email-footer a {
            color: #000000; /* Black */
            text-decoration: none;
            font-weight: bold;
        }
        .email-footer a:hover {
            color: #ffd700; /* Gold on hover */
        }
    </style>
</head>
<body>
<div class="email-container">
    <!-- Header -->
    <div class="email-header">
        <h1>Verify Your Email Address</h1>
    </div>

    <!-- Body -->
    <div class="email-body">
        <p>Hello {{ $name }},</p>
        <p>Thank you for registering with us! To complete your registration, please verify your email address by clicking the button below:</p>
        <a href="{{ $verificationUrl }}">Verify Email Address</a>
        <p>If you did not create an account, no further action is required.</p>
        <p>Thank you,<br>The Gilded Canvas Team</p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
        <p>If you’re having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:</p>
        <p><a href="{{ $verificationUrl }}">{{ $verificationUrl }}</a></p>
    </div>
</div>
</body>
</html>
