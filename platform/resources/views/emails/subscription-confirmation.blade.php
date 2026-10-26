<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscription Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">Subscription Confirmed!</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Your subscription has been confirmed! Here are your subscription details:</p>
        
        <div style="background-color: #f9fafb; padding: 20px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Plan:</strong> {{ ucfirst($subscription->plan) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($subscription->status) }}</p>
            <p><strong>Started:</strong> {{ $subscription->created_at->format('M d, Y') }}</p>
        </div>
        
        <p>You now have access to all the features of your plan.</p>
        
        <p style="text-align: center; margin: 30px 0;">
            <a href="{{ route('dashboard') }}" style="background-color: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 5px;">Go to Dashboard</a>
        </p>
        
        <p>Thank you for subscribing!</p>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
