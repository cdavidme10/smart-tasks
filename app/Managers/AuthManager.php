<?php

namespace App\Managers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * @extends BaseManager<User>
 */
class AuthManager extends BaseManager
{
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
    }

    public function create(array $data): Model
    {
        $data['password'] = bcrypt($data['password']);

        return parent::create($data);
    }

    /**
     * @param  array<string, mixed>  $credentials
     * @return array{user: User, token: string}
     */
    public function login(array $credentials): array
    {
        if (! Auth::attempt($credentials)) {
            abort(401, 'Invalid credentials.');
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    /**
     * @phpstan-assert-if-true UserRepository $this->repository
     */
    protected function userRepository(): UserRepository
    {
        return assert($this->repository instanceof UserRepository)
            ? $this->repository
            : throw new \LogicException('Repository is not a UserRepository');
    }

    public function logout(): void
    {
        /** @var User $user */
        $user = Auth::user();

        $this->userRepository()->deleteTokens($user);
        Auth::logout();
    }
}
