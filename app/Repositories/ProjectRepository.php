<?php

namespace App\Repositories;

use App\Models\Project;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

/**
 * @extends BaseRepository<Project>
 */
class ProjectRepository extends BaseRepository
{
    protected function filters(): array
    {
        return [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::exact('status'),
        ];
    }

    protected function includes(): array
    {
        return ['user', 'tasks'];
    }

    protected function sorts(): array
    {
        return [
            AllowedSort::field('name'),
            AllowedSort::field('startDate', 'start_date'),
            AllowedSort::field('endDate', 'end_date'),
        ];
    }

    protected function fields(): array
    {
        return [
            'id', 'name', 'description', 'start_date', 'end_date', 'created_at', 'updated_at',
        ];
    }
}
