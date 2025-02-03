<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'bank_logo',
        'account_holder',
        'branch_code',
        'account_number',
        'iban',
        'status',
        'order'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    // Yardımcı metodlar
    public function getFormattedIban()
    {
        return trim(chunk_split($this->iban, 4, ' '));
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeCurrency($query, $currency)
    {
        return $query->where('currency', $currency);
    }

    public function getBankLogoUrlAttribute()
    {
        return $this->bank_logo ? asset($this->bank_logo) : null;
    }
} 