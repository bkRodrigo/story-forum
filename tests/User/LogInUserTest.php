<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LogInUserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * If not authorized, we shouldn't return a user
     *
     * @return void
     */
    public function test_user_logs_in_with_correct_credentials(): void
    {
        $pwd = 'passw0rd';
        $attributes = User::factory()->create(['password' => $pwd])->only('email');
        $attributes['password'] = $pwd;
        // Cannot get user when not logged in
        $this->postJson('/api/login', $attributes)->assertSuccessful();
    }

    /**
     * If not authorized, we shouldn't return a user
     *
     * @return void
     */
    public function test_user_login_fail_with_incorrect_credentials(): void
    {
        $attributes = User::factory()->create(['password' => 'passw0rd'])->only('email');
        $attributes['password'] = 'wrong_pwd!';
        // Cannot get user when not logged in
        $this->postJson('/api/login', $attributes)
            ->assertJsonValidationErrors(['email']);
    }
}
