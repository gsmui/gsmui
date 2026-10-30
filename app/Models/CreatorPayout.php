<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreatorPayout extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'creator_id', 'amount', 'status', 'method', 'reference',
        'paid_at', 'created_at',
    ];

    protected function casts(): array
    {
        return [
            'amount' => 'decimal:2',
            'paid_at' => 'datetime',
            'created_at' => 'datetime',
        ];
    }

    public function creator() { return $this->belongsTo(\App\Domains\Users\Models\User::class, 'creator_id'); }
}
