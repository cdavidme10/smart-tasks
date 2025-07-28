<?php

namespace App\Filters;

use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

/**
 *  @implements Filter<Task>
 */
class ProjectIdFilter implements Filter
{
    /**
     * @return Builder<Task>
     */
    public function __invoke(
        Builder $query,
        mixed $value,
        string $property
    ): Builder {
        return $query->where('project_id', $value);
    }
}
