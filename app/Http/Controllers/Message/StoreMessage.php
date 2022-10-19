<?php

namespace App\Http\Controllers\Message;

use App\Models\Message;
use http\Env\Response;
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

        $message = Message::create([
            'body' => request('body'),
            'user_id' => auth()->user()->id,
            'thread_id' =>  request('thread_id'),
        ]);

        return response()->json($message);
    }
}
