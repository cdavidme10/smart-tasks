<?php

namespace App\Providers;

use App\Managers\AuthManager;
use App\Managers\ProjectManager;
use App\Managers\TaskManager;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(TaskManager::class, function ($app) {
            return new TaskManager($app->make(TaskRepository::class));
        });

        $this->app->bind(ProjectManager::class, function ($app) {
            return new ProjectManager($app->make(ProjectRepository::class));
        });

        $this->app->bind(AuthManager::class, function ($app) {
            return new AuthManager($app->make(UserRepository::class));
        });
    }

    public function boot(): void
    {
        //
    }
}
