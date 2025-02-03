<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Demo kullanıcı
        $user = User::create([
            'name' => 'Demo Kullanıcı',
            'email' => 'demo@example.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Demo kullanıcı için adres
        Address::create([
            'user_id' => $user->id,
            'address_title' => 'Ev Adresi',
            'city' => 'İstanbul',
            'district' => 'Kadıköy',
            'full_address' => 'Caferağa Mah. Moda Cad. No:123 D:4',
            'postal_code' => '34710',
            'is_default' => true,
        ]);

        // Ek test kullanıcıları
        User::factory(10)->create()->each(function ($user) {
            Address::factory()->count(rand(1, 3))->create([
                'user_id' => $user->id
            ]);
        });
    }
} 