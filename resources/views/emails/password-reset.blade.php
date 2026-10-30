<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Your Password</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">Reset Your Password</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>You are receiving this email because we received a password reset request for your account.</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ route('password.reset', ['token' => $token, 'email' => $user->email]) }}" style="background-color: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Reset Password</a>
        </p>
        
        <p>This password reset link will expire in 60 minutes.</p>
        
        <p>If you did not request a password reset, no further action is required.</p>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
