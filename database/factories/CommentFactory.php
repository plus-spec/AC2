<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->paragraph(2),
            'user_id' => User::factory(),
            'task_id' => Task::factory(),
        ];
    }
}