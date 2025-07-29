<?php

namespace Tests\Feature\App\Http\Api\Controllers;

use App\Contracts\ManagerInterface;
use App\Managers\ProjectManager;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Response;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    private const PROJECTS_ROUTE = '/api/v1/projects';

    protected function setUp(): void
    {
        parent::setUp();

        $this->app->bind(ManagerInterface::class, ProjectManager::class);
    }

    public function test_index_returns_projects_list(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        Project::factory(3)->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::PROJECTS_ROUTE);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(3, 'data');
    }

    public function test_show_returns_single_project(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::PROJECTS_ROUTE."/{$project->id}");

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['name' => $project->name]);
    }

    public function test_show_returns_empty_project_for_different_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->getJson(self::PROJECTS_ROUTE."/{$project->id}");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_store_creates_project_successfully(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $payload = [
            'name' => 'Nuevo Proyecto',
            'description' => 'Descripción ejemplo',
            'start_date' => '2025-01-01',
            'end_date' => '2025-01-31',
        ];

        $response = $this->actingAs($user, 'sanctum')->postJson(self::PROJECTS_ROUTE, $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['name' => 'Nuevo Proyecto']);

        $this->assertDatabaseHas('projects', ['name' => 'Nuevo Proyecto', 'user_id' => $user->id]);
    }

    public function test_store_fails_validation_if_name_missing(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $payload = ['description' => 'Sin nombre'];

        $response = $this->actingAs($user, 'sanctum')->postJson(self::PROJECTS_ROUTE, $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_update_modifies_project(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $payload = ['name' => 'Proyecto Actualizado'];

        $response = $this->actingAs($user, 'sanctum')->putJson(self::PROJECTS_ROUTE."/{$project->id}", $payload);

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonFragment(['name' => 'Proyecto Actualizado']);

        $this->assertDatabaseHas('projects', ['id' => $project->id, 'name' => 'Proyecto Actualizado']);
    }

    public function test_update_fails_validation_if_name_empty(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $payload = ['name' => ''];

        $response = $this->actingAs($user, 'sanctum')->putJson(self::PROJECTS_ROUTE."/{$project->id}", $payload);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_destroy_deletes_project(): void
    {
        /** @var User $user */
        $user = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson(self::PROJECTS_ROUTE."/{$project->id}");

        $response->assertStatus(204);

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
    }

    public function test_destroy_unprocessable_entity_for_different_user(): void
    {
        /** @var User $user */
        $user = User::factory()->create();

        $otherUser = User::factory()->create();
        $project = Project::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'sanctum')->deleteJson(self::PROJECTS_ROUTE."/{$project->id}");

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);

        $this->assertNotSoftDeleted('projects', ['id' => $project->id]);
    }
}
