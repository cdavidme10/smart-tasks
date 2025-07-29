<?php

namespace App\Repositories;

use App\Filters\ProjectIdFilter;
use App\Models\Task;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @extends BaseRepository<Task>
 */
class TaskRepository extends BaseRepository
{
    protected function filters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::custom('projectId', new ProjectIdFilter),
            AllowedFilter::exact('status'),
            AllowedFilter::partial('title'),
            AllowedFilter::partial('description'),
        ];
    }

    protected function includes(): array
    {
        return ['user', 'project'];
    }

    protected function sorts(): array
    {
        return [
            AllowedSort::field('title'),
            AllowedSort::field('status'),
            AllowedSort::field('dueDate', 'due_date'),
            AllowedSort::field('createdAt', 'created_at'),
            AllowedSort::field('updatedAt', 'updated_at'),
        ];
    }

    protected function fields(): array
    {
        return [
            'id',
            'title',
            'description',
            'status',
            'due_date',
            'project_id',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }
}
