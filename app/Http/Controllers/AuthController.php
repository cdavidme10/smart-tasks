<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Managers\AuthManager;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

class AuthController extends Controller
{
    public function __construct(
        protected readonly AuthManager $authManager,
        protected readonly LoggerInterface $logger
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authManager->create($request->validated());

        return response()->json([
            'message' => 'User registered successfully.',
            'user' => $user,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $result = $this->authManager->login($request->validated());

        return response()->json([
            'message' => 'Login successful.',
            'token' => $result['token'],
            'user' => $result['user'],
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authManager->logout();

        return response()->json([
            'message' => 'Logout successful.',
        ]);
    }
}
