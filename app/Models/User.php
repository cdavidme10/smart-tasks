<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * @property-read int $id
 * @property string $name
 * @property string $email
 * @property-read string $password
 * @property-read string $remember_token
 * @property string $milestone
 * @property ?string $email_verified_at
 * @property-read Project[] $projects
 * @property-read Task[] $tasks
 * @property-read PersonalAccessToken[] $tokens
 */
class User extends Authenticatable
{
    use HasApiTokens;

    /** @phpstan-use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return HasMany<Project, User>
     */
    public function projects(): HasMany
    {
        /** @var HasMany<Project, User> */
        return $this->hasMany(Project::class);
    }

    /**
     * @return HasMany<Task, User>
     */
    public function tasks(): HasMany
    {
        /** @var HasMany<Task, User> */
        return $this->hasMany(Task::class);
    }

    public function scopeWithoutMilestone(Builder $query): Builder
    {
        return $query->whereNull('milestone');
    }
}
