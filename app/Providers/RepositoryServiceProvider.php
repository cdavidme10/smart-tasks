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
        $this->app->singleton(ProjectRepository::class, function ($app) {
            return new ProjectRepository(new Project);
        });

        $this->app->singleton(TaskRepository::class, function ($app) {
            return new TaskRepository(new Task);
        });

        $this->app->singleton(UserRepository::class, function ($app) {
            return new UserRepository(new User);
        });
    }

    public function boot(): void
    {
        //
    }
}
