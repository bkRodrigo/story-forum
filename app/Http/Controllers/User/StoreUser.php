<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Http\Controllers\Controller;

class StoreUser extends Controller
{
    /**
     * Store a new user
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function __invoke(Request $request)
    {
        // Validate request
        $request->validate([
            'full_name' => 'required|string|max:150',
            'email' => 'required|unique:users|email:rfc,dns',
            'password' => ['required', Password::min(8)],
        ]);

        $user = $this->createUser(
            $request->input('full_name'),
            $request->input('email'),
            $request->input('password'),
            $request->input('bio', null),
        );

        return response()->json([
            'token' => $user->createToken('client')->plainTextToken
        ]);
    }

    /**
     * Create a user
     *
     * @param string $name
     * @param string $email
     * @param string $password
     * @param ?string $biography
     *
     * @return User
     */
    protected function createUser(
        string $name, string $email, string $password, ?string $biography
    ) : User
    {
        return User::create(request(['full_name', 'email', 'password', 'bio']));
    }
}
