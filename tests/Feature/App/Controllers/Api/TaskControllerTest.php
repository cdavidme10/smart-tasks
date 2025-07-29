<?php

namespace Tests\Feature\App\Http\Api\Controllers;

use App\Contracts\ManagerInterface;
use App\Enums\TaskStatus;
use App\Managers\TaskManager;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    private const TASKS_ROUTE = '/api/v1/tasks';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(ManagerInterface::class, TaskManager::class);
    }

    public function test_index_returns_tasks_list(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Task::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::TASKS_ROUTE);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data');
    }

    public function test_show_returns_single_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::TASKS_ROUTE."/{$task->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['title' => $task->title]);
    }

    public function test_show_returns_unprocessable_for_different_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::TASKS_ROUTE."/{$task->id}");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_store_creates_task_successfully(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $payload = [
            'title' => 'Nueva Tarea',
            'description' => 'Descripción tarea',
            'status' => TaskStatus::Pending->value,
            'due_date' => '2025-12-31',
            'project_id' => $project->id,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson(self::TASKS_ROUTE, $payload);

        $response->assertStatus(Response::HTTP_CREATED)
            ->assertJsonFragment(['title' => 'Nueva Tarea']);

        $this->assertDatabaseHas('tasks', ['title' => 'Nueva Tarea', 'user_id' => $user->id]);
    }

    public function test_store_fails_validation_if_status_is_invalid(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $payload = [
            'title' => 'Tarea Inválida',
            'description' => 'Descripción',
            'status' => 'invalid-status',
            'due_date' => '2025-12-31',
            'project_id' => $project->id,
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson(self::TASKS_ROUTE, $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('status');

        $this->assertDatabaseMissing('tasks', ['title' => 'Tarea Inválida']);
    }

    public function test_store_fails_validation_if_title_missing(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $payload = ['description' => 'Sin título'];

        $response = $this->actingAs($user, 'sanctum')->postJson(self::TASKS_ROUTE, $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('title');
    }

    public function test_update_modifies_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $payload = ['title' => 'Tarea Actualizada'];

        $response = $this->actingAs($user, 'sanctum')->putJson(self::TASKS_ROUTE."/{$task->id}", $payload);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['title' => 'Tarea Actualizada']);

        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Tarea Actualizada']);
    }

    public function test_update_fails_validation_if_title_empty(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $payload = ['title' => ''];

        $response = $this->actingAs($user, 'sanctum')->putJson(self::TASKS_ROUTE."/{$task->id}", $payload);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('title');
    }

    public function test_destroy_deletes_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson(self::TASKS_ROUTE."/{$task->id}");

        $response->assertStatus(Response::HTTP_NO_CONTENT);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }

    public function test_destroy_unprocessable_entity_for_different_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson(self::TASKS_ROUTE."/{$task->id}");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertNotSoftDeleted('tasks', ['id' => $task->id]);
    }
}
