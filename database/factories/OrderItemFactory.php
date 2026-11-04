<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\PreparationType;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        $unitPrice = $this->faker->randomFloat(2, 4, 35);
        $quantity = $this->faker->randomFloat(3, 0.250, 2.500);

        return [
            'order_id' => Order::factory(),
            'product_id' => Product::factory(),
            'preparation_type_id' => PreparationType::factory(),

            'product_name' => ucfirst($this->faker->words(2,true)),
            'unit_price' => $unitPrice,
            'quantity' => $quantity,
            'subtotal' => round($unitPrice * $quantity, 2),
        ];
    }
}