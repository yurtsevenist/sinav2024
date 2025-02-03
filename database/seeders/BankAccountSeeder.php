<?php

namespace Database\Seeders;

use App\Models\BankAccount;
use Illuminate\Database\Seeder;

class BankAccountSeeder extends Seeder
{
    public function run()
    {
        $accounts = [
            [
                'bank_name' => 'Ziraat Bankası',
                'account_holder' => 'Örnek E-Ticaret A.Ş.',
                'iban' => 'TR33 0006 1005 1978 6457 8413 26',
                'account_number' => '12345678',
                'branch_code' => '1234',
                'branch_name' => 'Merkez Şube',
                'currency' => 'TRY',
                'order' => 1
            ],
            [
                'bank_name' => 'İş Bankası',
                'account_holder' => 'Örnek E-Ticaret A.Ş.',
                'iban' => 'TR66 0006 4000 0011 2233 4455 66',
                'account_number' => '87654321',
                'branch_code' => '4321',
                'branch_name' => 'Kadıköy Şubesi',
                'currency' => 'TRY',
                'order' => 2
            ],
            [
                'bank_name' => 'Garanti Bankası',
                'account_holder' => 'Örnek E-Ticaret A.Ş.',
                'iban' => 'TR05 0006 2000 7890 1234 5678 90',
                'account_number' => '11223344',
                'branch_code' => '999',
                'branch_name' => 'Şişli Şubesi',
                'currency' => 'USD',
                'order' => 3
            ]
        ];

        foreach ($accounts as $account) {
            BankAccount::create($account);
        }
    }
} 