<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => rtrim(fake()->realText(fake()->numberBetween(30, 60)), '.'),
            'description' => fake()->realText(fake()->numberBetween(80, 160)),
            'starts_at' => fake()->dateTimeBetween('now', '+1 month'),
            'ends_at' => fake()->dateTimeBetween('+1 month', '+2 months'),
        ];
    }
}
