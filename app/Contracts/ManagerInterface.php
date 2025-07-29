<?php

namespace App\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
interface ManagerInterface
{
    /**
     * @param  array<string, mixed>  $data
     * @return TModel
     */
    public function create(array $data): Model;

    /**
     * @return TModel|null
     */
    public function find(int $id): ?Model;

    /**
     * @return LengthAwarePaginator<int, TModel>
     */
    public function all(): LengthAwarePaginator;

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
