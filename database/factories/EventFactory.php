<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    protected $model = Event::class;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'event_date' => fake()->dateTimeBetween('-1 month', '+3 months')->format('Y-m-d'),
            'location' => fake()->city(),
            'client_name' => fake()->company(),
            'sold_price_cents' => fake()->numberBetween(80000, 800000),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
