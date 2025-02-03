<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Süper Admin
        Admin::create([
            'username' => 'superadmin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'first_name' => 'Süper',
            'last_name' => 'Admin',
            'phone' => '5551234567',
            'status' => true
        ]);

        // Diğer yöneticiler
        $admins = [
            [
                'username' => 'productmanager',
                'email' => 'products@example.com',
                'password' => Hash::make('password'),
                'first_name' => 'Ürün',
                'last_name' => 'Yöneticisi',
                'phone' => '5551234568',
                'status' => true
            ],
            [
                'username' => 'ordermanager',
                'email' => 'orders@example.com',
                'password' => Hash::make('password'),
                'first_name' => 'Sipariş',
                'last_name' => 'Yöneticisi',
                'phone' => '5551234569',
                'status' => true
            ]
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
} 