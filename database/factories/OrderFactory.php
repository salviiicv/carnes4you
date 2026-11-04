<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = $this->faker->randomFloat(2, 15, 150);
        $shippingCost = $this->faker->randomElement([0.00, 3.50, 4.99]);

        return [
            'user_id' => User::factory(),
            'tpv_session_id' => null,
            'shipping_address_id' => null,

            'order_number' => 'ORD-' . strtoupper($this->faker->bothify('??-#####')),
            'type' => $this->faker->randomElement(['online_delivery', 'online_pickup', 'tpv_sale']),
            'status' => $this->faker->randomElement(['pending', 'processing', 'completed', 'cancelled']),

            'payment_method' => $this->faker->randomElement(['cash', 'card', 'bizum']),
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),

            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'total' => $subtotal + $shippingCost,

            'notes' => $this->faker->optional(0.3)->sentence(),
        ];
    }
}