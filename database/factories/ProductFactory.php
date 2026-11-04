<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        $costPrice = $this->faker->randomFloat(2, 3, 25);

        return [
            'supplier_id' => Supplier::factory(),
            'name' => ucfirst($this->faker->words(2, true)),
            'description' => $this->faker->sentence(),
            
            'cost_price' => $costPrice,
            'price' => $costPrice + $this->faker->randomFloat(2, 2, 10),
            
            'stock' => $this->faker->randomFloat(3, 1, 50),
            'min_quantity' => 0.250,
            'step_quantity' => 0.250,

            'unit_type' => 'kg',
            'is_active' => true,
        ];
    }
}