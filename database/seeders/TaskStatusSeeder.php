<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder 
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskStatus::firstOrCreate(['name' => 'To Do']);
        TaskStatus::firstOrCreate(['name' => 'In Progress']);
        TaskStatus::firstOrCreate(['name' => 'Done']);
        TaskStatus::firstOrCreate(['name' => 'Blocked']);
        TaskStatus::firstOrCreate(['name' => 'Awaiting Review']);
    }
}