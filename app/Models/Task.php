<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    /** @phpstan-use HasFactory<TaskFactory> */
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'title',
        'description',
        'project_id',
        'user_id',
        'completed',
    ];

    /**
     * @return HasOne<Project, Task>
     */
    public function project(): HasOne
    {
        /** @var HasOne<Project, Task> */
        return $this->hasOne(Project::class);
    }

    /**
     * @return HasOne<User, Task>
     */
    public function user(): HasOne
    {
        /** @var HasOne<User, Task> */
        return $this->hasOne(User::class);
    }
}
