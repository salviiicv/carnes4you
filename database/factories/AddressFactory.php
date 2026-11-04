<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'address_line' => $this->faker->streetName(),
            'country' => 'España',
            'state' => $this->faker->state(),
            'province' => $this->faker->state(),
            'city' => $this->faker->city(),
            'zip' => $this->faker->postcode(),
            'street_number' => (string) $this->faker->buildingNumber(),
            'floor' => (string) $this->faker->numberBetween(1, 5),
            'door' => $this->faker->randomElement(['A', 'B', 'C', '1º', '2º', 'Izquierda', 'Derecha']),
        ];
    }
}