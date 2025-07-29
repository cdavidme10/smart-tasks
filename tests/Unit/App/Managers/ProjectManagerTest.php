<?php

namespace Tests\Unit\App\Managers;

use App\Managers\ProjectManager;
use App\Models\Project;
use App\Models\User;
use App\Repositories\ProjectRepository;
use Tests\TestCase;

class ProjectManagerTest extends TestCase
{
    protected ProjectManager $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = new ProjectManager(new ProjectRepository(new Project));
    }

    public function test_all_returns_paginated_projects_for_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $otherUser = User::factory()->create();

        Project::factory(25)->create(['user_id' => $user->id]);
        Project::factory()->create(['user_id' => $otherUser->id]);

        $paginator = $this->manager->all();

        $this->assertCount(15, $paginator->items());
        $this->assertEquals(25, $paginator->total());
    }

    public function test_create_project(): void
    {
        $user = User::factory()->create();

        $data = [
            'name' => 'Test Project',
            'description' => 'Description',
            'start_date' => '2025-01-01',
            'end_date' => '2025-12-31',
            'user_id' => $user->id,
        ];

        $project = $this->manager->create($data);

        $this->assertDatabaseHas('projects', ['name' => 'Test Project']);
        $this->assertEquals('Test Project', $project->name);
    }

    public function test_find_project(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $this->actingAs($user);

        $project = Project::factory()->create(['user_id' => $user->id]);

        $found = $this->manager->find($project->id);

        $this->assertNotNull($found);
        $this->assertEquals($project->id, $found->id);
    }

    public function test_update_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $updated = $this->manager->update($project, ['name' => 'Updated']);

        $this->assertEquals('Updated', $updated->name);
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Updated']);
    }

    public function test_delete_project(): void
    {
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $this->manager->delete($project);

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }
}
