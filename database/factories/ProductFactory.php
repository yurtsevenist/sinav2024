<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(3, true);
        return [
            'category_id' => Category::factory(),
            'name' => ucfirst($name),
            'description' => $this->faker->paragraphs(3, true),
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'sku' => strtoupper($this->faker->unique()->bothify('??###???')),
            'slug' => Str::slug($name),
            'status' => $this->faker->boolean(80)
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => true
            ];
        });
    }

    public function inStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock_quantity' => $this->faker->numberBetween(1, 100)
            ];
        });
    }

    public function outOfStock()
    {
        return $this->state(function (array $attributes) {
            return [
                'stock_quantity' => 0
            ];
        });
    }
} 