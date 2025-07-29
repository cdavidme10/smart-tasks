<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DefaultUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::query()->firstOrCreate(
            ['email' => 'g9lNl@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('p1S$w0rd.23'),
            ]
        );

        $user->projects()->saveMany(Project::factory(3)->make());

        foreach ($user->projects as $project) {
            $project->tasks()->saveMany(Task::factory(3)->make());
        }
    }
}
