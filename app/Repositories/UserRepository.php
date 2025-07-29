<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @extends BaseRepository<User>
 */
class UserRepository extends BaseRepository
{
    protected function filters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::exact('email'),
        ];
    }

    protected function includes(): array
    {
        return ['projects', 'tasks'];
    }

    protected function sorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('email'),
        ];
    }

    protected function fields(): array
    {
        return [
            'id', 'name', 'email', 'created_at', 'updated_at', 'milestone',
        ];
    }

    public function findByEmail(string $email): ?User
    {
        return User::query()->where('email', $email)->first();
    }

    public function deleteTokens(User $user): void
    {
        $user->tokens()->delete();
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsersWithoutMilestone(): Collection
    {
        return User::query()->withoutMilestone()->get();
    }
}
