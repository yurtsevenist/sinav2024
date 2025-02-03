<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            'Telefonlar' => [
                [
                    'name' => 'iPhone 14 Pro',
                    'price' => 49999.99,
                    'stock' => 50
                ],
                [
                    'name' => 'Samsung Galaxy S23',
                    'price' => 39999.99,
                    'stock' => 45
                ]
            ],
            'Bilgisayarlar' => [
                [
                    'name' => 'MacBook Pro M2',
                    'price' => 69999.99,
                    'stock' => 30
                ],
                [
                    'name' => 'Lenovo ThinkPad X1',
                    'price' => 44999.99,
                    'stock' => 25
                ]
            ],
            'Erkek Giyim' => [
                [
                    'name' => 'Klasik Kesim Takım Elbise',
                    'price' => 3999.99,
                    'stock' => 100
                ],
                [
                    'name' => 'Pamuklu T-Shirt',
                    'price' => 299.99,
                    'stock' => 200
                ]
            ]
        ];

        foreach ($products as $categoryName => $categoryProducts) {
            $category = Category::where('name', $categoryName)->first();
            
            if ($category) {
                foreach ($categoryProducts as $product) {
                    $newProduct = Product::create([
                        'category_id' => $category->id,
                        'name' => $product['name'],
                        'description' => 'Bu ürün için örnek açıklama metni. Detaylı ürün özellikleri ve açıklamaları burada yer alacak.',
                        'price' => $product['price'],
                        'stock_quantity' => $product['stock'],
                        'sku' => Str::random(10),
                        'slug' => Str::slug($product['name']),
                        'status' => true
                    ]);

                    // Her ürün için örnek görsel
                    ProductImage::create([
                        'product_id' => $newProduct->id,
                        'image_url' => 'products/default.jpg',
                        'order' => 0,
                        'is_default' => true
                    ]);
                }
            }
        }

        // Ek rastgele ürünler
        Category::all()->each(function ($category) {
            Product::factory(5)->create([
                'category_id' => $category->id
            ])->each(function ($product) {
                ProductImage::factory(rand(2, 4))->create([
                    'product_id' => $product->id
                ]);
            });
        });
    }
} 