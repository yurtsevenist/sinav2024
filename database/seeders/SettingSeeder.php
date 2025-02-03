<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Genel ayarlar
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'Örnek E-Ticaret Sitesi',
                'type' => 'text',
                'description' => 'Site adı'
            ],
            [
                'group' => 'general',
                'key' => 'site_description',
                'value' => 'En iyi ürünler, en uygun fiyatlarla',
                'type' => 'text',
                'description' => 'Site açıklaması'
            ],
            [
                'group' => 'general',
                'key' => 'site_logo',
                'value' => 'logo.png',
                'type' => 'file',
                'description' => 'Site logosu'
            ],

            // İletişim ayarları
            [
                'group' => 'contact',
                'key' => 'contact_email',
                'value' => 'info@example.com',
                'type' => 'email',
                'description' => 'İletişim e-posta adresi'
            ],
            [
                'group' => 'contact',
                'key' => 'contact_phone',
                'value' => '0850 123 4567',
                'type' => 'text',
                'description' => 'İletişim telefon numarası'
            ],
            [
                'group' => 'contact',
                'key' => 'contact_address',
                'value' => 'Örnek Mahallesi, E-Ticaret Caddesi No:1 Kadıköy/İstanbul',
                'type' => 'textarea',
                'description' => 'Şirket adresi'
            ],

            // Sosyal medya
            [
                'group' => 'social',
                'key' => 'facebook_url',
                'value' => 'https://facebook.com/example',
                'type' => 'url',
                'description' => 'Facebook sayfası'
            ],
            [
                'group' => 'social',
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/example',
                'type' => 'url',
                'description' => 'Instagram sayfası'
            ],

            // Kargo ayarları
            [
                'group' => 'shipping',
                'key' => 'free_shipping_min_amount',
                'value' => '250',
                'type' => 'number',
                'description' => 'Ücretsiz kargo minimum sipariş tutarı'
            ],
            [
                'group' => 'shipping',
                'key' => 'default_shipping_cost',
                'value' => '29.90',
                'type' => 'number',
                'description' => 'Varsayılan kargo ücreti'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
} 