<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            [
                'key' => 'site_name',
                'value' => 'Laravel E-ticaret',
                'type' => 'string',
                'group' => 'general'
            ],
            [
                'key' => 'contact_phone',
                'value' => '0850 123 4567',
                'type' => 'string',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_email',
                'value' => 'info@example.com',
                'type' => 'string',
                'group' => 'contact'
            ],
            [
                'key' => 'contact_address',
                'value' => 'İstanbul, Türkiye',
                'type' => 'string',
                'group' => 'contact'
            ],
            [
                'key' => 'free_shipping_min_amount',
                'value' => 250,
                'type' => 'integer',
                'group' => 'shipping'
            ],
            [
                'key' => 'social_facebook',
                'value' => 'https://facebook.com',
                'type' => 'string',
                'group' => 'social'
            ],
            [
                'key' => 'social_twitter',
                'value' => 'https://twitter.com',
                'type' => 'string',
                'group' => 'social'
            ],
            [
                'key' => 'social_instagram',
                'value' => 'https://instagram.com',
                'type' => 'string',
                'group' => 'social'
            ],
            [
                'key' => 'meta_title',
                'value' => 'Laravel E-ticaret - Online Alışveriş',
                'type' => 'string',
                'group' => 'seo'
            ],
            [
                'key' => 'meta_description',
                'value' => 'Laravel ile geliştirilmiş modern e-ticaret sitesi',
                'type' => 'string',
                'group' => 'seo'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
} 