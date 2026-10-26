<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Your Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #6366f1;">Your Invoice</h1>
        
        <p>Hello {{ $user->name }},</p>
        
        <p>Here is your invoice for your recent purchase:</p>
        
        <div style="background-color: #f9fafb; padding: 20px; border-radius: 5px; margin: 20px 0;">
            <p><strong>Invoice Number:</strong> {{ $invoice->invoice_number }}</p>
            <p><strong>Amount:</strong> ${{ number_format($invoice->amount, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
            <p><strong>Date:</strong> {{ $invoice->created_at->format('M d, Y') }}</p>
        </div>
        
        <p>Thank you for your purchase!</p>
        
        <p>Best regards,<br>The GsmUi Team</p>
    </div>
</body>
</html>
