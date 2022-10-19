<?php

namespace App\Http\Controllers\Thread;

use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class IndexThread extends Controller
{
    /**
     * Get Threads
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        return response()->json(Thread::with('user', 'messages')->get());
    }
}
