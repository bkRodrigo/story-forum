<?php

namespace App\Http\Controllers\Message;

use App\Models\Message;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;

class UpdateMessage extends Controller
{
    /**
     * Update a message.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke(int $id) : JsonResponse
    {
        $payload = [
            'id' => $id,
            'body' => request('body'),
        ];
        validator($payload, [
            'id' => 'required|exists:messages',
            'body' => 'required|string|min:3|max:1000',
        ])->validate();

        $message = Message::where('id', $id)->first();
        if ($message->user->id !== auth()->user()->id) {
            return response()->json('unauthorized', 403);
        }
        if (Carbon::now() > $message->created_at->addMinutes(5)) {
            return response()->json('message no longer editable', 403);
        }

        $message->body = $payload['body'];
        $message->save();

        return response()->json($message, 200);
    }
}
