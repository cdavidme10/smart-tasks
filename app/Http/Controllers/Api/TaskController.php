<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Task\DeleteRequest;
use App\Http\Requests\Api\Task\IndexRequest;
use App\Http\Requests\Api\Task\ShowRequest;
use App\Http\Requests\Api\Task\StoreRequest;
use App\Http\Requests\Api\Task\UpdateRequest;
use App\Models\Task;

/**
 * @extends BaseApiController<Task>
 */
class TaskController extends BaseApiController
{
    protected function indexRequest(): string
    {
        return IndexRequest::class;
    }

    protected function storeRequest(): string
    {
        return StoreRequest::class;
    }

    protected function showRequest(): string
    {
        return ShowRequest::class;
    }

    protected function updateRequest(): string
    {
        return UpdateRequest::class;
    }

    protected function destroyRequest(): string
    {
        return DeleteRequest::class;
    }
}
