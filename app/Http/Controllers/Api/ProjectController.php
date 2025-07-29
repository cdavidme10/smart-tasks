<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\Project\DeleteRequest;
use App\Http\Requests\Api\Project\IndexRequest;
use App\Http\Requests\Api\Project\ShowRequest;
use App\Http\Requests\Api\Project\StoreRequest;
use App\Http\Requests\Api\Project\UpdateRequest;
use App\Models\Project;

/**
 * @extends BaseApiController<Project>
 */
class ProjectController extends BaseApiController
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
