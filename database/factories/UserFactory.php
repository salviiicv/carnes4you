<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'surname' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'role' => $this->faker->randomElement(['cliente', 'empleado', 'admin']),
            'pin_code' => $this->faker->numerify('####'),
            'internal_notes' => $this->faker->optional(0.2)->sentence(),
            'password' => 'testtest',
        ];
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
        ]);
    }

    public function empleado(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'empleado',
        ]);
    }
}