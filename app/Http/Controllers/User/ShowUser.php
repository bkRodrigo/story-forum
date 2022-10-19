<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\User;

class ShowUser extends Controller
{
    /**
     * Return the specified user.
     *
     * @param Request $request
     * @param int $id
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request, int $id) : JsonResponse
    {
        validator(['id' => $id], [
            'id' => 'required|exists:users',
        ])->validate();

        // Fetch the user
        $user = User::where('id', $id)->first();

        $props = ['full_name', 'bio'];
        if (auth()->user()->id === $user->id) {
            array_push($props, 'email');
        }
        return response()->json($user->only($props));
    }
}
