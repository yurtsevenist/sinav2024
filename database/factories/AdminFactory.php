<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'phone' => $this->faker->numerify('555########'),
            'status' => $this->faker->boolean(80),
            'remember_token' => Str::random(10),
            'last_login_at' => $this->faker->optional()->dateTimeThisMonth()
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

    public function inactive()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => false
            ];
        });
    }
} 