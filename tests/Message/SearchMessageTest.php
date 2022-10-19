<?php

namespace Tests\Message;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class SearchMessageTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Must be logged in to create a message
     *
     * @return void
     */
    public function test_must_be_logged_in_to_search_for_a_message(): void
    {
        // Cannot search when not logged in
        $this->getJson('/api/message', [])->assertUnauthorized();
    }

    /**
     * Cannot search for messages in a thread that does not exist
     *
     * @return void
     */
    public function test_fail_to_search_in_non_existent_threads(): void
    {
        // Create a sample user
        $user = User::factory()->create();

        $this->actingAs($user)
            ->json('GET',  '/api/message', ['thread_id' => 999])
            ->assertInvalid(['thread_id']);
    }

    /**
     * Search all the messages associated to the logged-in user
     *
     * @return void
     */
    public function test_search_all_messages(): void
    {
        // Create a sample user
        $user = User::factory()->create();
        $validBody = 'My valid message post.';
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Message::factory()->create([
            'body' => $validBody, 'thread_id' => $thread->id, 'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->json('GET',  '/api/message', ['term' => 'valid message'])
            ->assertJsonFragment(['body' => $validBody]);
    }

    /**
     * Search for messages within a thread
     *
     * @return void
     */
    public function test_search_messages_within_a_thread(): void
    {
        // Create a sample user
        $user = User::factory()->create();
        $validBody = 'My valid message post.';
        $thread = Thread::factory()->create(['user_id' => $user->id]);
        Message::factory()->create([
            'body' => $validBody, 'thread_id' => $thread->id, 'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->json(
                'GET',
                '/api/message',
                ['term' => 'valid message', 'thread_id' => $thread->id]
            )->assertJsonFragment(['body' => $validBody]);
    }

    /**
     * Get all messages
     *
     * @return void
     */
    public function test_get_all_messages(): void
    {
        // Create a sample user
        $user = User::factory()->create();

        $this->actingAs($user)->getJson('/api/message')->assertSuccessful();
    }
}
