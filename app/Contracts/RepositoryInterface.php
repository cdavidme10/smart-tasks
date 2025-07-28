<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @template TModel of Model
 */
interface RepositoryInterface
{
    /**
     * @return QueryBuilder<TModel>
     */
    public function query(): QueryBuilder;

    /**
     * @return TModel|null
     */
    public function find(int $id): ?Model;

    /**
     * @return Collection<int, TModel>
     */
    public function all(): Collection;

    /**
     * @return LengthAwarePaginator<int, TModel>
     */
    public function paginated(): LengthAwarePaginator;

    /**
     * @param  array<string, mixed>  $data
     * @return TModel
     */
    public function create(array $data): Model;

    /**
     * @param  TModel  $model
     * @param  array<string, mixed>  $data
     * @return TModel
     */
    public function update(Model $model, array $data): Model;

    /**
     * @param  TModel  $model
     */
    public function delete(Model $model): void;
}
