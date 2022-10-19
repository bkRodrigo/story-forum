<?php

namespace App\Http\Controllers\Thread;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;

class ShowThread extends Controller
{
    /**
     * Update a message.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $id) : JsonResponse
    {
        validator(['id' => $id], [
            'id' => 'required|exists:threads',
        ])->validate();

        return response()->json(
            Thread::with('user', 'messages')
                ->where('id', $id)
                ->first()
        );
    }
}
