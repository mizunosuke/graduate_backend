<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Fish;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ranking>
 */
class RankingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'start' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'end' => $this->faker->dateTimeBetween('now', '+1 month'),
            'num_of_participant' => $this->faker->numberBetween(1, 100),
            'fish_id' => Fish::factory(),
        ];
    }
}
