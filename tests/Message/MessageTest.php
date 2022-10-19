<?php

namespace Tests\Message;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class MessageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Must be logged in to create a message
     *
     * @return void
     */
    public function test_must_be_logged_in_to_create_a_message(): void
    {
        // Cannot create when not logged in
        $this->postJson('/api/message', [])->assertUnauthorized();
    }

    /**
     * Must be logged in to update a message
     *
     * @return void
     */
    public function test_must_be_logged_in_to_update_a_message(): void
    {
        // Cannot update when not logged in
        $this->putJson('/api/message/1', [])->assertUnauthorized();
    }

    /**
     * Incorrectly formatted messages should fail to create
     *
     * @return void
     */
    public function test_fail_to_create_message_on_invalid_body(): void
    {
        $user = User::factory()->create();

        // body cannot be empty
        $attributesEmptyBody = Message::factory()->raw(['body' => '']);
        $this->actingAs($user)
            ->postJson('/api/message', $attributesEmptyBody)
            ->assertInvalid(['body']);

        // body must be less than 10000 characters long
        $buildingBody = true;
        $body = '';
        while ($buildingBody) {
            $body .= fake()->paragraph(10);
            $buildingBody = strlen($body) < 1000;
        }
        $attributesEmptyBody = Message::factory()->raw(['body' => $body]);
        $this->actingAs($user)
            ->postJson('/api/message', $attributesEmptyBody)
            ->assertInvalid(['body']);
    }

    /**
     * Cannot create a message if it's getting associated to a thread that
     * does not exist
     *
     * @return void
     */
    public function test_fail_to_create_message_for_non_existent_thread(): void
    {
        $user = User::factory()->create();
        $validBody = 'My valid message post.';

        $attributesEmptyBody = Message::factory()->raw([
            'body' => $validBody, 'thread_id' => 999
        ]);
        $this->actingAs($user)
            ->postJson('/api/message', $attributesEmptyBody)
            ->assertInvalid(['thread_id']);
    }

    /**
     * Test the creation of a message
     *
     * @return void
     */
    public function test_create_message(): void
    {
        $user = User::factory()->create();
        $validBody = 'My valid message post.';
        $thread = Thread::factory()->create(['user_id' => $user->id]);

        $attributesEmptyBody = Message::factory()->raw([
            'body' => $validBody, 'thread_id' => $thread->id
        ]);
        $this->actingAs($user)
            ->postJson('/api/message', $attributesEmptyBody)
            ->assertSuccessful();
    }

    /**
     * If the message doesn't exist, return an error (don't blow up)
     *
     * @return void
     */
    public function test_cannot_update_an_inexistent_message(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->putJson('/api/message/999', ['body', 'my updated message'])
            ->assertInvalid(['id']);
    }

    /**
     * Incorrectly formatted messages should fail to update
     *
     * @return void
     */
    public function test_fail_to_update_message_on_invalid_body(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['user_id' => $user->id]);

        // body cannot be empty
        $attributesEmptyBody = Message::factory()->raw(['body' => '']);
        $this->actingAs($user)
            ->putJson("/api/message/$message->id", $attributesEmptyBody)
            ->assertInvalid(['body']);

        // body must be less than 10000 characters long
        $buildingBody = true;
        $body = '';
        while ($buildingBody) {
            $body .= fake()->paragraph(10);
            $buildingBody = strlen($body) < 1000;
        }
        $attributesEmptyBody = Message::factory()->raw(['body' => $body]);
        $this->actingAs($user)
            ->putJson("/api/message/$message->id", $attributesEmptyBody)
            ->assertInvalid(['body']);
    }

    /**
     * Test updating a message
     *
     * @return void
     */
    public function test_update_message(): void
    {
        $user = User::factory()->create();
        $message = Message::factory()->create(['user_id' => $user->id]);

        $attributesEmptyBody = Message::factory()->raw(['body' => 'my valid message']);
        $this->actingAs($user)
            ->putJson("/api/message/$message->id", $attributesEmptyBody)
            ->assertSuccessful();
    }
}
