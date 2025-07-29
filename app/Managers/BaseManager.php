<?php

namespace App\Managers;

use App\Contracts\ManagerInterface;
use App\Contracts\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 *
 * @implements ManagerInterface<TModel>
 */
abstract class BaseManager implements ManagerInterface
{
    /**
     * @param  RepositoryInterface<TModel>  $repository
     */
    public function __construct(protected readonly RepositoryInterface $repository) {}

    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    public function find(int $id): ?Model
    {
        return $this->repository->find($id);
    }

    public function all(): LengthAwarePaginator
    {
        return $this->repository->paginated();
    }

    public function update(Model $model, array $data): Model
    {
        return $this->repository->update($model, $data);
    }

    public function delete(Model $model): void
    {
        $this->repository->delete($model);
    }
}
