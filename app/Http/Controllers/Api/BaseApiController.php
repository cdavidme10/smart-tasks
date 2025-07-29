<?php

namespace App\Http\Controllers\Api;

use App\Contracts\ApiControllerInterface;
use App\Contracts\ManagerInterface;
use App\Http\Controllers\Controller;
use App\Traits\ResolvesFormRequest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Psr\Log\LoggerInterface;

/**
 * @template TModel of Model
 *
 * @implements ApiControllerInterface<TModel>
 */
abstract class BaseApiController extends Controller implements ApiControllerInterface
{
    use ResolvesFormRequest;

    /**
     * @param  ManagerInterface<TModel>  $manager
     */
    public function __construct(
        protected readonly ManagerInterface $manager,
        protected readonly LoggerInterface $logger
    ) {}

    public function index(): JsonResponse
    {
        $this->resolveFormRequest($this->indexRequest());

        return response()->json($this->manager->all());
    }

    public function store(): JsonResponse
    {
        $request = $this->resolveFormRequest($this->storeRequest());
        $data = $request->validated();

        return response()->json($this->manager->create($data), 201);
    }

    public function show(int $id): JsonResponse
    {
        $request = $this->resolveFormRequest($this->showRequest());
        $model = $this->manager->find($id);
        if (! $model) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return response()->json($model);
    }

    public function update(int $id): JsonResponse
    {
        $request = $this->resolveFormRequest($this->updateRequest());
        $data = $request->validated();

        $model = $this->manager->find($id);

        if (! $model) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        return response()->json($this->manager->update($model, $data));
    }

    public function destroy(int $id): JsonResponse
    {
        $request = $this->resolveFormRequest($this->destroyRequest());
        $data = $request->validated();

        $model = $this->manager->find($id);

        if (! $model) {
            return response()->json(['message' => 'Resource not found'], 404);
        }

        $this->manager->delete($model);

        return response()->json(['message' => 'Resource deleted'], 204);
    }

    abstract protected function indexRequest(): string;

    abstract protected function storeRequest(): string;

    abstract protected function showRequest(): string;

    abstract protected function updateRequest(): string;

    abstract protected function destroyRequest(): string;
}
