<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserCreateTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Cannot create when using blank values for required attributes
     *
     * @return void
     */
    public function test_the_create_user_req_has_valid_params()
    {
        // Test empty name
        $attributesNoName = User::factory()->raw(['full_name' => '']);
        $this->postJson('/api/user', $attributesNoName)->assertInvalid(['full_name']);

        // Test empty email
        $attributesNoEmail = User::factory()->raw(['email' => '']);
        $this->postJson('/api/user', $attributesNoEmail)->assertInvalid(['email']);

        // Test invalid email
        $attributesNoEmail = User::factory()->raw(['email' => 'invalid']);
        $this->postJson('/api/user', $attributesNoEmail)->assertInvalid(['email']);

        // Test empty password
        $attributesNoPwd = User::factory()->raw(['password' => '']);
        $this->postJson('/api/user', $attributesNoPwd)->assertInvalid(['password']);

        // Test password too short
        $attributesNoPwd = User::factory()->raw(['password' => '1234']);
        $this->postJson('/api/user', $attributesNoPwd)->assertInvalid(['password']);
    }

    /**
     * Email must be unique
     *
     * @return void
     */
    public function test_email_must_be_unique()
    {
        // Creating a user requires a name, email and a password
        $attributes = User::factory()->raw(['email' => 'test@test.com']);
        $this->postJson('/api/user', $attributes);
        $this->assertDatabaseHas('users', ['email' => 'test@test.com']);
        $this->postJson('/api/user', $attributes)->assertInvalid(['email']);
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_user_gets_created_with_valid_params()
    {
        // Creating a user requires a name, email and a password
        $attributes = User::factory()->raw(['email' => 'test@test.com']);
        $this->postJson('/api/user', $attributes)->assertSuccessful();
        $this->assertDatabaseHas('users', ['email' => $attributes['email']]);
    }
}
