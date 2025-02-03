<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            'Elektronik' => [
                'Telefonlar',
                'Bilgisayarlar',
                'Televizyonlar',
                'Aksesuarlar'
            ],
            'Moda' => [
                'Erkek Giyim',
                'Kadın Giyim',
                'Çocuk Giyim',
                'Ayakkabı'
            ],
            'Ev & Yaşam' => [
                'Mobilya',
                'Ev Tekstili',
                'Mutfak Gereçleri',
                'Dekorasyon'
            ],
            'Kitap & Hobi' => [
                'Kitaplar',
                'Müzik',
                'Film',
                'Hobi Malzemeleri'
            ]
        ];

        foreach ($categories as $mainCategory => $subCategories) {
            $parent = Category::create([
                'name' => $mainCategory,
                'slug' => Str::slug($mainCategory),
                'order' => 0,
                'status' => true
            ]);

            foreach ($subCategories as $index => $subCategory) {
                Category::create([
                    'parent_id' => $parent->id,
                    'name' => $subCategory,
                    'slug' => Str::slug($subCategory),
                    'order' => $index,
                    'status' => true
                ]);
            }
        }
    }
} 