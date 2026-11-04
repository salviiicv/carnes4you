<?php

namespace Database\Factories;

use App\Models\TpvSession;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashMovementFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tpv_session_id' => TpvSession::factory(),
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['in', 'out']),
            'amount' => $this->faker->randomFloat(2, 5, 150),
            'description' => $this->faker->optional(0.6)->sentence(),
        ];
    }
}