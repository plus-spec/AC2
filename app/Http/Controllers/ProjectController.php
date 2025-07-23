<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with(['owner', 'tasks.status', 'tasks.assignedTo', 'members'])->get();
        return view('index', compact('projects'));
    }

    public function create()
    {
        $users = User::all();
        return view('projects.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
        ]);

        Project::create($request->all());

        return redirect()->route('home')->with('success', 'Проект успешно создан!');
    }

    public function edit(Project $project)
    {
        $users = User::all();
        return view('projects.edit', compact('project', 'users'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
        ]);

        $project->update($request->all());

        return redirect()->route('home')->with('success', 'Проект успешно обновлен!');
    }

    public function destroy(Project $project)
    {
        $project->tasks()->delete();
        $project->delete();
        return redirect()->route('home')->with('success', 'Проект успешно удален!');
    }

    public function createTask(Project $project)
    {
        $users = User::all();
        $taskStatuses = TaskStatus::all();
        return view('tasks.create', compact('project', 'users', 'taskStatuses'));
    }

    public function storeTask(Request $request)
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'assigned_to_id' => 'nullable|exists:users,id',
            'status_id' => 'required|exists:task_statuses,id',
            'due_date' => 'nullable|date',
        ]);

        Task::create($request->all());

        return redirect()->route('home')->with('success', 'Задача успешно добавлена!');
    }
}