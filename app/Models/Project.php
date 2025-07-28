<?php

namespace App\Models;

use Database\Factories\ProjectFactory;
use HasUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    /** @phpstan-use HasFactory<ProjectFactory> */
    use HasFactory;

    use HasUser;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'status',
        'start_date',
        'end_date',
    ];

    /**
     * @return HasMany<Task, Project>
     */
    public function tasks(): HasMany
    {
        /** @var HasMany<Task, Project> */
        return $this->hasMany(Task::class);
    }

    /**
     * @return BelongsTo<User, Project>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Project> */
        return $this->belongsTo(User::class);
    }
}
