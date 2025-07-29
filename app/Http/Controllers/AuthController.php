<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Managers\AuthManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Psr\Log\LoggerInterface;

class AuthController extends Controller
{
    private const TOKEN_TYPE = 'Bearer';

    private const EXPIRATION_TIME = '60 Minutes';

    public function __construct(
        protected readonly AuthManager $authManager,
        protected readonly LoggerInterface $logger
    ) {}

    public function register(RegisterRequest $request): JsonResponse
    {
        $token = $this->authManager->register($request->validated());

        return response()->json([
            'message' => 'User registered successfully.',
            'token' => $token,
            'token_type' => self::TOKEN_TYPE,
            'expires_in' => self::EXPIRATION_TIME,
        ], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authManager->login($request->validated());

        return response()->json([
            'message' => 'Login successful.',
            'token' => $token,
            'token_type' => self::TOKEN_TYPE,
            'expires_in' => self::EXPIRATION_TIME,
        ]);
    }

    public function logout(): JsonResponse
    {
        $this->authManager->logout();

        return response()->json([
            'message' => 'Logout successful.',
        ], Response::HTTP_NO_CONTENT);
    }
}
