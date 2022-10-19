<?php

namespace App\Http\Controllers\Thread;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class StoreThread extends Controller
{
    /**
     * Store a new thread
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Validate request
        $request->validate([
            'title' => 'required|string|min:3|max:60',
        ]);

        $thread = Thread::create(['title' => request('title')]);
        $thread->user()->associate(auth()->user())->save();

        return response()->json($thread);
    }
}
