<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;
use App\Models\Fish;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
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
            'user_id' => User::inRandomOrder()->first()->id,
            'attachment' => $this->faker->imageUrl(),
            'fish_id' => Fish::inRandomOrder()->first()->id,
            'size' => $this->faker->randomNumber(3),
            'day_of_fishing' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
