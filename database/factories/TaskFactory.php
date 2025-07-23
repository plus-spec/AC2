<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\User;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(5),
            'description' => fake()->paragraph(),
            'project_id' => Project::factory(),
            'assigned_to_id' => User::factory(),
            'status_id' => TaskStatus::inRandomOrder()->first()->id ?? TaskStatus::factory()->create()->id,
            'due_date' => fake()->dateTimeBetween('now', '+1 year'),
        ];
    }
}