<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'icon',
        'commission_rate',
        'status',
        'order'
    ];

    protected $casts = [
        'commission_rate' => 'decimal:2',
        'status' => 'boolean'
    ];

    // İlişkiler
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Yardımcı metodlar
    public function getIconUrlAttribute()
    {
        return $this->icon ? asset($this->icon) : null;
    }

    public function calculateCommission($amount)
    {
        return $amount * ($this->commission_rate / 100);
    }

    public function isAvailableForAmount($amount)
    {
        if ($this->min_amount && $amount < $this->min_amount) {
            return false;
        }

        if ($this->max_amount && $amount > $this->max_amount) {
            return false;
        }

        return true;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }
} 