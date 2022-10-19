<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Thread>
 */
class ThreadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => fake()->sentence(3),
            'user_id' => function () {
                if (User::all()->count() === 0) {
                    $user = User::factory()->create();
                } else {
                    $user = User::all()->random();
                }
                return $user->id;
            },
        ];
    }
}
