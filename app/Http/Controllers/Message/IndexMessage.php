<?php

namespace App\Http\Controllers\Message;

use App\Models\Message;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Collection;

class IndexMessage extends Controller
{
    /**
     * Get
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        $threadId = request('thread_id');
        $thread = null;
        $term = request('term');
        $case = 0;
        $case += $threadId ? 1 : 0;
        $case += $term ? 2 : 0;

        if ($threadId) {
            validator(
                ['thread_id' => $threadId],
                ['thread_id' => 'exists:threads,id']
            )->validate();
            $thread = Thread::where('id', $threadId)->first();
        }

        $user = auth()->user();
        $messages = match ($case) {
            0 => $this->fetchMessages($user),
            1 => $this->fetchMessagesInThread($user, $thread),
            2 => $this->search($user, $term),
            3 => $this->searchInThread($user, $thread, $term),
        };

        return response()->json($messages);
    }

    /**
     * Fetch all messages belonging to the user
     *
     * @param User $user
     *
     * @return Collection<User>
     */
    protected function fetchMessages(User $user): Collection
    {
        return Message::where('user_id', $user->id)
            ->get();
    }

    /**
     * Fetch all messages belonging to the user within a specific thread
     *
     * @param User $user
     * @param Thread $thread
     * @return Collection<User>
     */
    protected function fetchMessagesInThread(User $user, Thread $thread): Collection
    {
        return Message::where('user_id', $user->id)
            ->where('thread_id', $thread->id)
            ->get();
    }

    /**
     * Fetch all messages belonging to the user within a specific thread whose
     * body contains the $term
     *
     * @param User $user
     * @param Thread $thread
     * @param string $term
     * @return Collection<User>
     */
    protected function searchInThread(User $user, Thread $thread, string $term): Collection
    {
        return Message::where('user_id', $user->id)
            ->where('thread_id', $thread->id)
            ->where('body', 'LIKE', '%' . $term . '%')
            ->get();
    }

    /**
     * Fetch all messages belonging to the user whose body contains the $term
     *
     * @param User $user
     * @param string $term
     * @return Collection<User>
     */
    protected function search(User $user, string $term): Collection
    {
        return Message::where('user_id', $user->id)
            ->where('body', 'LIKE', '%' . $term . '%')
            ->get();
    }
}
