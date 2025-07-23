<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            TaskStatusSeeder::class,
        ]);
        $users = User::factory(10)->create();
        $users->each(function ($user) use ($users) {
            Project::factory(rand(2, 3))->create(['owner_id' => $user->id])
                ->each(function ($project) use ($users) {
                    $project->members()->attach($users->random(rand(1, 5))->pluck('id'));

                    Task::factory(rand(5, 10))->create(['project_id' => $project->id])
                        ->each(function ($task) use ($users) {
                            Comment::factory(rand(0, 3))->create([
                                'task_id' => $task->id,
                                'user_id' => $users->random()->id,
                            ]);
                        });
                });
        });

        
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
    }
}