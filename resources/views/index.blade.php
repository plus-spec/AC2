<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Система Управления Проектами</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <style>
        body { background-color: #f0f2f5; min-height: 100vh; }
        .container { margin-top: 30px; margin-bottom: 30px; background-color: #ffffff; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); }
        .header-title { font-size: 3.5rem; font-weight: 700; color: #4a4a4a; text-shadow: 2px 2px 4px rgba(0,0,0,0.1); background-image: linear-gradient(45deg, #007bff, #6f42c1); -webkit-background-clip: text; -webkit-text-fill-color: transparent; display: inline-block; }
        .project-card { border: 1px solid #dee2e6; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05); transition: transform 0.2s ease-in-out; background-color: #fdfdfd; }
        .project-card:hover { transform: translateY(-5px); }
        .project-card h2 { color: #007bff; margin-bottom: 10px; font-size: 1.8rem; }
        .task-item { padding: 10px 15px; border-radius: 5px; margin-bottom: 8px; font-size: 0.95rem; }

        .status-To-Do { background-color: #e9ecef; border-left: 5px solid #6c757d; } /* Серый */
        .status-In-Progress { background-color: #fff3cd; border-left: 5px solid #ffc107; } /* Желтый */
        .status-Done { background-color: #d4edda; border-left: 5px solid #28a745; } /* Зеленый */
        .status-Blocked { background-color: #f8d7da; border-left: 5px solid #dc3545; } /* Красный */
        .status-Awaiting-Review { background-color: #cfe2ff; border-left: 5px solid #0d6efd; } /* Синий */
        
        .task-item strong { color: #343a40; }
        .task-item small { color: #6c757d; }
        .task-description { font-size: 0.8em; color: #555; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4 header-title">Система Управления Проектами</h1>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="text-center mb-5">
            <a href="{{ route('projects.create') }}" class="btn btn-success btn-lg">
                Создать новый проект....
            </a>
        </div>

        @if($projects->isEmpty())
            <div class="alert alert-info text-center py-4" role="alert">
                <h4 class="alert-heading">Ой!</h4>
                <p>Проекты пока не созданы. Запустите сидеры, чтобы заполнить базу данных тестовыми данными.</p>
                <hr>
                <p class="mb-0">Или добавьте свой первый проект!</p>
            </div>
        @else
            <div class="row">
                @foreach ($projects as $project)
                    <div class="col-md-6 col-lg-4">
                        <div class="project-card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h2 class="card-title mb-0">{{ $project->name }}</h2>
                                    <div class="btn-group" role="group" aria-label="Project actions">
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-sm btn-outline-primary">
                                            Редактировать
                                        </a>
                                        <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Удалить</button>
                                        </form>
                                    </div>
                                </div>
                                
                                <p class="card-text text-muted">{{ $project->description }}</p>
                                <p class="card-text"><small class="text-secondary">Владелец: {{ $project->owner->name ?? 'Неизвестен' }}</small></p>

                                <hr>
                                <h3 class="h5 mb-3">Участники:</h3>
                                @if($project->members->isEmpty())
                                    <p class="text-muted"><small>Нет участников, кроме владельца</small></p>
                                @else
                                    <ul class="list-unstyled">
                                        @foreach($project->members as $member)
                                            <li><span class="badge bg-secondary me-1 my-1">{{ $member->name }}</span></li>
                                        @endforeach
                                    </ul>
                                @endif

                                <hr>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h3 class="h5 mb-0">Задачи:</h3>
                                    <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-sm btn-primary">
                                        + Добавить задачу
                                    </a>
                                </div>
                                
                                @if($project->tasks->isEmpty())
                                    <p class="text-muted"><small>Задач пока нет.</small></p>
                                @else
                                    <div>
                                        @foreach ($project->tasks as $task)
                                            @php
                                                $normalizedStatusName = str_replace(' ', '-', $task->status->name ?? 'To Do');
                                            @endphp
                                            <div class="task-item status-{{ $normalizedStatusName }}">
                                                <strong>{{ $task->title }}</strong><br>
                                                <small>
                                                    Назначено: {{ $task->assignedTo->name ?? 'Не назначено' }}
                                                    (Статус: {{ $task->status->name ?? 'Неизвестен' }})
                                                    @if($task->due_date)
                                                        | Срок: {{ $task->due_date->format('d.m.Y') }}
                                                    @endif
                                                </small>
                                                @if($task->description)
                                                    <p class="mb-0 mt-1 task-description">{{ Str::limit($task->description, 50) }}</p>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>