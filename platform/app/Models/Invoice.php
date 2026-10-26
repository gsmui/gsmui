<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'paddle_invoice_id', 'status', 'total', 'currency',
        'pdf_url', 'line_items',
    ];

    protected function casts(): array
    {
        return ['total' => 'decimal:2', 'line_items' => 'array'];
    }

    public function user() { return $this->belongsTo(User::class); }
}
