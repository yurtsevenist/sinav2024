<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition()
    {
        $name = $this->faker->unique()->words(2, true);
        return [
            'parent_id' => null,
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'order' => $this->faker->numberBetween(0, 10),
            'status' => $this->faker->boolean(80)
        ];
    }

    public function subCategory()
    {
        return $this->state(function (array $attributes) {
            return [
                'parent_id' => Category::factory()
            ];
        });
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => true
            ];
        });
    }
} 