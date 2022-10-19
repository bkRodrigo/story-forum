<?php

namespace Database\Factories;

use App\Models\Thread;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Message>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'body' => fake()->paragraph(3),
            'user_id' => function () {
                if (User::all()->count() === 0) {
                    $user = User::factory()->create();
                } else {
                    $user = User::all()->random();
                }
                return $user->id;
            },
            'thread_id' => function () {
                if (Thread::all()->count() === 0) {
                    $thread = Thread::factory()->create();
                } else {
                    $thread = Thread::all()->random();
                }
                return $thread->id;
            },
        ];
    }
}
