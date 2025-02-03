<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // İlişkiler
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    // Yardımcı metodlar
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    public function isParent()
    {
        return is_null($this->parent_id);
    }
} 