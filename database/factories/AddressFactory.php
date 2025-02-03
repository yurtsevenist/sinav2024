<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    protected $model = Address::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'address_title' => $this->faker->randomElement(['Ev', 'İş', 'Yazlık', 'Diğer']),
            'city' => $this->faker->city(),
            'district' => $this->faker->randomElement(['Kadıköy', 'Beşiktaş', 'Üsküdar', 'Şişli', 'Maltepe']),
            'full_address' => $this->faker->streetAddress(),
            'postal_code' => $this->faker->postcode(),
            'is_default' => $this->faker->boolean(20)
        ];
    }

    public function default()
    {
        return $this->state(function (array $attributes) {
            return [
                'is_default' => true
            ];
        });
    }
} 