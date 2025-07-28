<?php

namespace App\Providers;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ProjectRepository::class, function ($app) {
            return new ProjectRepository($app->make(Project::class));
        });

        $this->app->bind(TaskRepository::class, function ($app) {
            return new TaskRepository($app->make(Task::class));
        });

        $this->app->bind(UserRepository::class, function ($app) {
            return new UserRepository($app->make(User::class));
        });
    }

    public function boot(): void
    {
        //
    }
}
