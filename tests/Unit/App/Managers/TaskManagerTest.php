<?php

namespace Tests\Unit\App\Managers;

use App\Enums\TaskStatus;
use App\Managers\TaskManager;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Repositories\TaskRepository;
use Tests\TestCase;

class TaskManagerTest extends TestCase
{
    protected TaskManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->manager = new TaskManager(new TaskRepository(new Task));
    }

    public function test_all_returns_paginated_tasks_for_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        Project::factory()->create(['user_id' => $user->id]);
        Task::factory(23)->create(['user_id' => $user->id]);

        $paginator = $this->manager->all();

        $this->assertCount(15, $paginator->items());
        $this->assertEquals(23, $paginator->total());
    }

    public function test_create_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $data = [
            'title' => 'Sample Task',
            'description' => 'Task description',
            'status' => TaskStatus::Pending->value,
            'due_date' => '2025-12-31',
            'project_id' => $project->id,
            'user_id' => $user->id,
        ];

        $task = $this->manager->create($data);

        $this->assertDatabaseHas('tasks', ['title' => 'Sample Task']);
        $this->assertEquals('Sample Task', $task->title);
    }

    public function test_find_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $task = Task::factory()->create(['user_id' => $user->id]);

        $found = $this->manager->find($task->id);

        $this->assertNotNull($found);
        $this->assertEquals($task->id, $found->id);
    }

    public function test_update_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $updated = $this->manager->update($task, ['title' => 'Updated Task']);

        $this->assertEquals('Updated Task', $updated->title);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'title' => 'Updated Task']);
    }

    public function test_delete_task(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $task = Task::factory()->create(['user_id' => $user->id]);

        $this->manager->delete($task);

        $this->assertSoftDeleted('tasks', ['id' => $task->id]);
    }
}
