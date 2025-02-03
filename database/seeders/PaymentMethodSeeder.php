<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run()
    {
        $methods = [
            [
                'name' => 'Kredi Kartı',
                'code' => 'credit_card',
                'commission_rate' => 1.50,
                'min_amount' => 1.00,
                'max_amount' => 50000.00,
                'order' => 1,
                'icon' => 'credit-card.png'
            ],
            [
                'name' => 'Havale/EFT',
                'code' => 'bank_transfer',
                'commission_rate' => 0,
                'min_amount' => 1.00,
                'max_amount' => 100000.00,
                'order' => 2,
                'icon' => 'bank-transfer.png'
            ],
            [
                'name' => 'Kapıda Ödeme',
                'code' => 'cash_on_delivery',
                'commission_rate' => 0,
                'fixed_commission' => 14.99,
                'min_amount' => 1.00,
                'max_amount' => 10000.00,
                'order' => 3,
                'icon' => 'cash.png'
            ]
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
} 