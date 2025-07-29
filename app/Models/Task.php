<?php

namespace App\Models;

use App\Enums\TaskStatus;
use App\Traits\HasUser;
use Database\Factories\TaskFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read int $id
 * @property string $title
 * @property string $description
 * @property int $project_id
 * @property int $user_id
 * @property string $status
 * @property string $due_date
 * @property ?string $deleted_at
 * @property ?string $created_at
 * @property ?string $updated_at
 * @property-read ?Project $project
 * @property-read User $user
 */
class Task extends Model
{
    /** @phpstan-use HasFactory<TaskFactory> */
    use HasFactory;

    use HasUser;
    use SoftDeletes;

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
        'status',
        'due_date',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'status' => TaskStatus::class,
    ];

    /**
     * @return BelongsTo<Project, Task>
     */
    public function project(): BelongsTo
    {
        /** @var BelongsTo<Project, Task> */
        return $this->belongsTo(Project::class);
    }

    /**
     * @return BelongsTo<User, Task>
     */
    public function user(): BelongsTo
    {
        /** @var BelongsTo<User, Task> */
        return $this->belongsTo(User::class);
    }
}
