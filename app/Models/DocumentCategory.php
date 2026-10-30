<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCategory extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'sort_order'];

    public function documents() { return $this->hasMany(\App\Domains\Documentation\Models\Document::class, 'category_id'); }
}
