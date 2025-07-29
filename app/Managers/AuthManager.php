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
     * @param  array<string, mixed>  $data
     */
    public function register(array $data): string
    {
        $user = $this->create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return $token;
    }

    /**
     * @param  array<string, mixed>  $data
     */
    public function login(array $data): string
    {
        if (! Auth::attempt($data)) {
            abort(401, 'Invalid credentials.');
        }

        /** @var User $user */
        $user = Auth::user();

        return $user->createToken('auth_token')->plainTextToken;
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
    }

    public function checkMilestone(): void
    {
        $totalUsers = $this->userRepository()->count();
        $milestone = intdiv($totalUsers, 100);
        $usersToUpdate = $this->userRepository()->getUsersWithoutMilestone();

        if ($milestone > 0 && $usersToUpdate->count() % 100 === 0) {

            $usersToUpdate->each(function (User $user) use ($milestone) {

                $user->milestone = "milestone {$milestone}";
                $user->save();
            });
        }
    }
}
