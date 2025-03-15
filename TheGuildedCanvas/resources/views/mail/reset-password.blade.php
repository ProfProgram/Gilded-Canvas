<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Reset Your Password</title>
  <style>
    /* Global Reset */
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 20px 0; /* Adds space above and below the email container */
      color: #333;
    }

    .email-container {
      max-width: 600px;
      margin: 0 auto;
      background-color: #ffffff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Header */
    .email-header {
      background-color: #000000; /* Black */
      color: #FFD700;           /* Gold */
      text-align: center;
      padding: 25px 20px;
    }

    .email-header h1 {
      margin: 0;
      font-size: 28px;
      font-weight: bold;
    }

    /* Body */
    .email-body {
      padding: 25px 20px;
      line-height: 1.6;
    }

    .email-body p {
      margin-bottom: 16px;
      font-size: 16px;
    }

    /* Call-to-Action Button */
    .btn {
      display: inline-block;
      margin: 20px 0;
      padding: 12px 24px;
      background-color: #FFD700; /* Gold */
      color: #000000;            /* Black */
      text-decoration: none;
      border-radius: 4px;
      font-size: 16px;
      font-weight: bold;
    }

    .btn:hover {
      background-color: #e6b800; /* Darker gold on hover */
    }

    /* Footer */
    .email-footer {
      background-color: #f4f4f4;
      text-align: center;
      padding: 20px;
      font-size: 14px;
      color: #777777;
    }

    .email-footer a {
      color: #000000; /* Black link */
      text-decoration: none;
      font-weight: bold;
    }

    .email-footer a:hover {
      color: #FFD700; /* Gold on hover */
    }
  </style>
</head>
<body>
  <div class="email-container">
    <!-- Header -->
    <div class="email-header">
      <h1>Reset Your Password</h1>
    </div>

    <!-- Body -->
    <div class="email-body">
      <p>Hello,</p>
      <p>
        You requested a password reset. Click the button below to reset your password:
      </p>
      <a href="{{ $resetUrl }}" class="btn">Reset Password</a>
      <p>
        If you didn’t request this, you can ignore this email.
      </p>
      <p>Thank you,<br>The Gilded Canvas Team</p>
    </div>

    <!-- Footer -->
    <div class="email-footer">
      <p>
        If you’re having trouble clicking the 
        <strong>“Reset Password”</strong> button,
        copy and paste the URL below into your web browser:
      </p>
      <p>
        <a href="{{ $resetUrl }}">{{ $resetUrl }}</a>
      </p>
    </div>
  </div>
</body>
</html>
