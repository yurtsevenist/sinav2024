<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'old_price',
        'stock_quantity',
        'sku',
        'status',
        'featured'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'old_price' => 'decimal:2',
        'status' => 'boolean',
        'featured' => 'boolean'
    ];

    // İlişkiler
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->ordered();
    }

    public function defaultImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_default', true);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    // Özellikler
    public function getDiscountPercentageAttribute()
    {
        if ($this->old_price && $this->old_price > $this->price) {
            return round((($this->old_price - $this->price) / $this->old_price) * 100);
        }
        return 0;
    }

    public function getImageUrlAttribute()
    {
        return $this->defaultImage ? $this->defaultImage->image_url : asset('images/no-image.png');
    }

    // Yardımcı metodlar
    public function decreaseStock($quantity)
    {
        $this->decrement('stock_quantity', $quantity);
    }

    public function increaseStock($quantity)
    {
        $this->increment('stock_quantity', $quantity);
    }

    public function hasStock($quantity = 1)
    {
        return $this->stock_quantity >= $quantity;
    }

    // Sorgular
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }
} 