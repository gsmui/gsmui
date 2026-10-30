<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to GsmUi</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">Welcome to GsmUi!</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Thank you for joining GsmUi! We're excited to have you on board.</p>
        
        <p>With GsmUi, you get access to:</p>
        <ul>
            <li>200+ premium Livewire components</li>
            <li>Beautiful themes with dark mode support</li>
            <li>Comprehensive documentation</li>
            <li>And much more!</li>
        </ul>
        
        <p>Get started by browsing our components:</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ route('components.index') }}" style="background-color: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Browse Components</a>
        </p>
        
        <p>If you have any questions, feel free to reach out to our support team.</p>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
