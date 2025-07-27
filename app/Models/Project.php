<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @phpstan-use HasFactory<ProjectFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'description'];

    /**
     * @return HasMany<Task, Project>
     */
    public function tasks(): HasMany
    {
        /** @var HasMany<Task, Project> */
        return $this->hasMany(Task::class);
    }

    /**
     * @return HasOne<User, Project>
     */
    public function user(): HasOne
    {
        /** @var HasOne<User, Project> */
        return $this->hasOne(User::class);
    }
}
