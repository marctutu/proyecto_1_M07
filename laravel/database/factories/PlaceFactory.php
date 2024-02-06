<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models\User;
use App\Models\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PlaceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = User::factory()->create();
        $file = File::factory()->create();
        
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraph(),
            'file_id' => $file->id,
            'latitude' => fake()->randomFloat(5, -90, 90),
            'longitude' => fake()->randomFloat(5, -180, 180),
            'author_id' => $user->id,
        ];
    }
}