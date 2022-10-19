<?php

namespace App\Http\Controllers\Message;

use App\Jobs\NotifyNewMessage;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class StoreMessage extends Controller
{
    /**
     * Store a new message
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Validate request
        $request->validate([
            'body' => 'required|string|min:3|max:1000',
            'thread_id' => 'required|exists:threads,id',
        ]);

        $message = $this->createMessage(
            request('body'), auth()->user()->id, request('thread_id')
        );

        return response()->json($message);
    }

    protected function createMessage($body, $userId, $threadId)
    {
        $message = Message::create([
            'body' => $body,
            'user_id' => $userId,
            'thread_id' =>  $threadId,
        ]);

        NotifyNewMessage::dispatch($message)->delay(now()->addMinute());

        return $message;
    }
}
