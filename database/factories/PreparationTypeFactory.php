<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PreparationTypeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => ucfirst($this->faker->unique()->word()),
        ];
    }
}