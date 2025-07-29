<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;

/**
 * @template TModel of Model
 */
interface ApiControllerInterface
{
    public function index(): JsonResponse;

    public function store(): JsonResponse;

    public function show(int $id): JsonResponse;

    public function update(int $id): JsonResponse;

    public function destroy(int $id): JsonResponse;
}
