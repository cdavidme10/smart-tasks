<?php

namespace App\Repositories;

use App\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedInclude;
use Spatie\QueryBuilder\AllowedSort;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @template TModel of Model
 *
 * @implements RepositoryInterface<TModel>
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @param  TModel  $model
     */
    public function __construct(protected readonly Model $model) {}

    public function query(): QueryBuilder
    {
        $builder = QueryBuilder::for($this->model::class);

        if (method_exists($this->model, 'scopeOwned')) {
            $builder->owned();
        }

        return $builder
            ->allowedFields($this->fields())
            ->allowedIncludes($this->includes())
            ->allowedFilters($this->filters())
            ->allowedSorts($this->sorts());
    }

    public function find(int $id): ?Model
    {
        return $this->query()->find($id);
    }

    public function all(): Collection
    {
        return $this->query()->get();
    }

    public function paginated(): LengthAwarePaginator
    {
        return $this->query()->paginate();
    }

    public function create(array $data): Model
    {
        if (
            Schema::hasColumn($this->model->getTable(), 'user_id') &&
            Auth::check()
        ) {
            $data['user_id'] = Auth::id();
        }

        return $this->model::query()->create($data);
    }

    public function update(Model $model, array $data): Model
    {
        $model->update($data);

        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }

    public function count(): int
    {
        return $this->query()->count();
    }

    /**
     * @return array<AllowedFilter|string>
     */
    abstract protected function filters(): array;

    /**
     * @return array<AllowedInclude|string>
     */
    abstract protected function includes(): array;

    /**
     * @return array<AllowedSort|string>
     */
    abstract protected function sorts(): array;

    /**
     * @return array<string>
     */
    abstract protected function fields(): array;
}
