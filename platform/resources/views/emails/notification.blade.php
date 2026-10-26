<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">{{ $subject }}</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <div style="margin: 20px 0;">
            {!! $body !!}
        </div>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
