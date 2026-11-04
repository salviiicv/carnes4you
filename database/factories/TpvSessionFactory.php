<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TpvSessionFactory extends Factory
{
    public function definition(): array
    {
        $startingCash = $this->faker->randomElement([50.00, 100.00, 150.00, 200.00]);

        return [
            'user_id' => User::factory(),
            'opened_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'closed_at' => null,
            'starting_cash' => $startingCash,
            'closing_cash' => null,
        ];
    }

    public function closed(): static
    {
        return $this->state(function (array $attributes) {
            $openedAt = $attributes['opened_at'] ?? now();
            $startingCash = $attributes['starting_cash'] ?? 100.00;

            return [
                'closed_at' => $this->faker->dateTimeBetween($openedAt, 'now'),
                'closing_cash' => $startingCash + $this->faker->randomFloat(2, 50, 500),
            ];
        });
    }
}