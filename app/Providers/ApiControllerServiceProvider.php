<?php

namespace App\Providers;

use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\TaskController;
use App\Managers\ProjectManager;
use App\Managers\TaskManager;
use Illuminate\Support\ServiceProvider;
use Psr\Log\LoggerInterface;

class ApiControllerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $logger = $this->app->make(LoggerInterface::class);

        $this->app->singleton(ProjectController::class, function ($app) use ($logger) {
            return new ProjectController(
                $app->make(ProjectManager::class),
                $logger
            );
        });

        $this->app->singleton(TaskController::class, function ($app) use ($logger) {
            return new TaskController(
                $app->make(TaskManager::class),
                $logger
            );
        });
    }

    public function boot(): void
    {
        //
    }
}
