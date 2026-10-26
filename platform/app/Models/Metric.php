<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'type', 'value', 'dimensions', 'recorded_at'];

    protected function casts(): array
    {
        return [
            'value' => 'float',
            'dimensions' => 'array',
            'recorded_at' => 'datetime',
        ];
    }
}
