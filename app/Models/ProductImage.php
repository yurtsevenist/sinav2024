<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image',
        'order',
        'is_default'
    ];

    protected $casts = [
        'is_default' => 'boolean'
    ];

    // İlişkiler
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Özellikler
    public function getImageUrlAttribute()
    {
        return $this->image ? asset($this->image) : asset('images/no-image.png');
    }

    // Sorgular
    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
} 