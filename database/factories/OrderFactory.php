<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        $user = User::factory()->create();
        $shippingAddress = Address::factory()->create(['user_id' => $user->id]);
        $billingAddress = Address::factory()->create(['user_id' => $user->id]);

        return [
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper($this->faker->unique()->bothify('##???###')),
            'total_amount' => $this->faker->randomFloat(2, 100, 5000),
            'shipping_cost' => $this->faker->randomFloat(2, 0, 50),
            'discount_amount' => $this->faker->randomFloat(2, 0, 100),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'order_status' => $this->faker->randomElement(['pending', 'processing', 'shipped', 'delivered', 'cancelled']),
            'shipping_address_id' => $shippingAddress->id,
            'billing_address_id' => $billingAddress->id,
            'notes' => $this->faker->optional()->sentence()
        ];
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'pending',
                'order_status' => 'pending'
            ];
        });
    }

    public function paid()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'paid'
            ];
        });
    }

    public function delivered()
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'paid',
                'order_status' => 'delivered'
            ];
        });
    }

    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'order_status' => 'cancelled'
            ];
        });
    }
} 