<?php

namespace Tests\Feature\App\Observers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserObserverTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_does_not_set_milestone_if_less_than_100_users(): void
    {
        User::factory(99)->create();

        $this->assertDatabaseMissing('users', ['milestone' => 'milestone 1']);
    }

    public function test_it_sets_milestone_1_when_100th_user_is_created(): void
    {
        User::factory(99)->create();

        User::factory()->create();

        $this->assertEquals(100, User::query()->where('milestone', 'milestone 1')->count());
    }

    public function test_it_sets_milestone_2_when_200th_user_is_created(): void
    {
        User::factory(299)->create();

        User::factory()->create();

        $this->assertEquals(100, User::query()->where('milestone', 'milestone 1')->count());
        $this->assertEquals(100, User::query()->where('milestone', 'milestone 2')->count());
        $this->assertEquals(100, User::query()->where('milestone', 'milestone 3')->count());
    }

    public function test_it_does_not_override_existing_milestone(): void
    {
        User::factory(99)->create(['milestone' => 'already tagged']);
        User::factory()->create();

        $this->assertEquals(0, User::query()->where('milestone', 'milestone 1')->count());
        $this->assertEquals(99, User::query()->where('milestone', 'already tagged')->count());
    }
}
