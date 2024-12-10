<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entry>
 */
class EntryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "type" => $this->faker->randomElement(["coffee", "coke", "wildkraut", "energydrink"]),
            "user_id" => 1,
            "created_at" => $this->faker->dateTimeThisYear(),
        ];
    }
}
