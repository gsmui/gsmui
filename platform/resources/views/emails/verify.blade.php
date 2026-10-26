<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Email</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">Verify Your Email Address</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Please click the button below to verify your email address:</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ $url }}" style="background-color: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Verify Email</a>
        </p>
        
        <p>If you did not create an account, no further action is required.</p>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
