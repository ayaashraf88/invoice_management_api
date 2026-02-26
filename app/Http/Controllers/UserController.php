<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Domain\Users\Services\AuthService;
use App\Http\Resources\LoginResource;

class UserController extends Controller
{
    public function __construct(private AuthService $authService) {}

    public function login(LoginRequest $request)
    {
        $token = $this->authService->authenticate($request->email, $request->password);

        if (!$token) {
            return response()->json([
                'data' => [
                    'message' => 'The provided credentials are incorrect.'
                ]
            ], 401);
        }

        return new LoginResource($token);
    }
}
