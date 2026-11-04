<?php
namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockMovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'product_id' => Product::factory(),
            'movement_type' => $this->faker->randomElement(['in', 'out', 'adjustment', 'waste']),
            'quantity' => $this->faker->randomFloat(3, 0.100, 20.000),
            'reason' => $this->faker->optional(0.5)->sentence(),
        ];
    }
}