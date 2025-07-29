<?php

namespace Tests\Unit\App\Managers;

use App\Managers\AuthManager;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthManagerTest extends TestCase
{
    use RefreshDatabase;

    protected AuthManager $manager;

    protected function setUp(): void
    {
        parent::setUp();
        User::flushEventListeners();

        $this->manager = app(AuthManager::class);
    }

    public function test_it_does_nothing_if_total_users_not_multiple_of_100(): void
    {
        User::factory(99)->create();

        $this->manager->checkMilestone();

        $this->assertDatabaseMissing('users', ['milestone' => 'milestone 1']);
    }

    public function test_it_assigns_milestone_to_users_without_milestone(): void
    {
        User::factory(99)->create();
        $this->manager->checkMilestone();

        $this->assertDatabaseMissing('users', ['milestone' => 'milestone 1']);

        User::factory(1)->create();
        $this->manager->checkMilestone();

        $this->assertEquals(100, User::query()->where('milestone', 'milestone 1')->count());
    }

    public function test_it_assigns_correct_milestone_number(): void
    {
        User::factory(100)->create();
        $this->manager->checkMilestone();

        $this->assertEquals(100, User::query()->where('milestone', 'milestone 1')->count());

        User::factory(100)->create();
        $this->manager->checkMilestone();

        $this->assertEquals(100, User::query()->where('milestone', 'milestone 2')->count());
    }
}
