<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'image',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Yardımcı metodlar
    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/no-image.jpg');
    }
} 