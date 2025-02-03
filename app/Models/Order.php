<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'shipping_cost',
        'discount_amount',
        'payment_status',
        'order_status',
        'shipping_address_id',
        'billing_address_id',
        'notes'
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'discount_amount' => 'decimal:2'
    ];

    // İlişkiler
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }

    public function billingAddress()
    {
        return $this->belongsTo(Address::class, 'billing_address_id');
    }

    // Yardımcı metodlar
    public function getSubtotalAttribute()
    {
        return $this->total_amount - $this->shipping_cost + $this->discount_amount;
    }

    public function getFinalTotalAttribute()
    {
        return $this->total_amount;
    }

    public function isPending()
    {
        return $this->payment_status === 'pending';
    }

    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    public function markAsPaid()
    {
        $this->update(['payment_status' => 'paid']);
    }

    public function markAsShipped()
    {
        $this->update(['order_status' => 'shipped']);
    }

    public function markAsDelivered()
    {
        $this->update(['order_status' => 'delivered']);
    }

    public function markAsCancelled()
    {
        $this->update(['order_status' => 'cancelled']);
    }
} 