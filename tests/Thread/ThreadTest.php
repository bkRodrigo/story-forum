<?php

namespace Tests\Thread;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Must be logged in to create a thread
     *
     * @return void
     */
    public function test_must_be_logged_in_to_create_a_thread(): void
    {
        // Cannot create when not logged in
        $this->postJson('/api/thread', [])->assertUnauthorized();
    }

    /**
     * Must be logged in to get threads
     *
     * @return void
     */
    public function test_must_be_logged_in_to_get_threads(): void
    {
        // Cannot get when not logged in
        $this->getJson('/api/thread')->assertUnauthorized();

    }

    /**
     * Must be logged in to get a thread
     *
     * @return void
     */
    public function test_must_be_logged_in_to_get_a_thread(): void
    {
        // Cannot get when not logged in
        $this->getJson('/api/thread/1')->assertUnauthorized();
    }

    /**
     * Cannot create a thread without a title
     *
     * @return void
     */
    public function test_fail_to_create_thread_on_incorrect_title(): void
    {
        $testEmail = 'test@test.com';
        $user = User::factory()->create(['email' => $testEmail]);

        // Title cannot be empty
        $attributesEmptyTitle = Thread::factory()->raw(['title' => '']);
        $this->actingAs($user)->postJson('/api/thread', $attributesEmptyTitle)->assertInvalid(['title']);

        // Title cannot be longer than 60 characters
        $attributesLongTitle = Thread::factory()->raw(['title' => fake()->sentence(60)]);
        $this->actingAs($user)->postJson('/api/thread', $attributesLongTitle)->assertInvalid(['title']);
    }

    /**
     * Given the correct set of data, create a thread
     *
     * @return void
     */
    public function test_create_thread(): void
    {
        $testEmail = 'test@test.com';
        $user = User::factory()->create(['email' => $testEmail]);

        $attributes = Thread::factory()->raw(['title' => 'My correctly sized title!']);
        $this->actingAs($user)->postJson('/api/thread', $attributes)->assertSuccessful();
        $this->assertDatabaseHas('threads', ['title' => $attributes['title']]);
    }

    /**
     * Get a collection of threads that belong to the user
     *
     * @return void
     */
    public function test_get_logged_in_user_threads(): void
    {
        // Create a sample user
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson("/api/thread");
        $response->assertOk();

        $thread = Thread::factory()->create(['user_id' => $user->id]);
        $message = Message::factory()->create(['user_id' => $user->id, 'thread_id' => $thread->id]);

        $response = $this->actingAs($user)->getJson("/api/thread");
        $response->assertJsonFragment(['body' => $message->body]);
    }

    /**
     * Get a thread and eager load the associated messages
     *
     * @return void
     */
    public function test_get_thread_and_associated_messages(): void
    {
        // Create a sample user
        $user = User::factory()->create();

        $thread = Thread::factory()->create(['user_id' => $user->id]);
        $message = Message::factory()->create(['user_id' => $user->id, 'thread_id' => $thread->id]);

        $response = $this->actingAs($user)->getJson("/api/thread/$thread->id");
        $response->assertSuccessful();
        $response->assertJsonFragment(['body' => $message->body]);
    }


}
