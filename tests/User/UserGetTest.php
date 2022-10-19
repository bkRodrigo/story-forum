<?php

namespace Tests\User;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class UserGetTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * If not authorized, we shouldn't return a user
     *
     * @return void
     */
    public function test_user_not_accessible_when_unauthorized(): void
    {
        // Cannot get user when not logged in
        $this->getJson('/api/user')->assertUnauthorized();
    }

    /**
     * Returns a user when it is authorized to do so
     *
     * @return void
     */
    public function test_gets_user_when_authorized(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->getJson('/api/user')->assertSuccessful();
    }

    /**
     * Doesn't return user password
     *
     * @return void
     */
    public function test_user_password_never_returned()
    {
        $testEmail = 'test@test.com';
        // Create a sample user
        $user = User::factory()->create(['email' => $testEmail]);

        $response = $this->actingAs($user)->getJson("/api/user/{$user->id}");
        $response->assertJson(['email' => $testEmail]);
        $response->assertJsonMissing([
            'password' => ''
        ]);
    }

    /**
     * Response includes the email if and only if the user making the request
     * is the target user
     *
     * @return void
     */
    public function test_user_email_returned_iff_fetching_logged_in_user()
    {
        $testEmail1 = 'test@test.com';
        $testEmail2 = 'test2@test.com';
        // Create a sample user
        $user1 = User::factory()->create(['email' => $testEmail1]);
        $user2 = User::factory()->create(['email' => $testEmail2]);

        $response = $this->actingAs($user1)->getJson("/api/user/{$user1->id}");
        $response->assertJson(['email' => $testEmail1]);

        $response = $this->actingAs($user1)->getJson("/api/user/{$user2->id}");
        $response->assertJsonMissing(['email' => '']);
    }
}
