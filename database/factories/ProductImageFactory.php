<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductImageFactory extends Factory
{
    protected $model = ProductImage::class;

    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'image_url' => 'products/default-' . $this->faker->numberBetween(1, 5) . '.jpg',
            'order' => $this->faker->numberBetween(0, 10),
            'is_default' => $this->faker->boolean(20)
        ];
    }

    public function default()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_default' => true,
                'order' => 0
            ];
        });
    }
} 