<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;

Route::get('/', [ProjectController::class, 'index'])->name('home');

Route::resource('projects', ProjectController::class);

Route::get('/projects/{project}/tasks/create', [ProjectController::class, 'createTask'])->name('projects.tasks.create');

Route::post('/tasks', [ProjectController::class, 'storeTask'])->name('tasks.store');
