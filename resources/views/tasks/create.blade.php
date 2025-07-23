<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу в проект: {{ $project->name }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body { background-color: #f0f2f5; min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .card { width: 100%; max-width: 600px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #007bff; }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="text-center mb-4">Добавить задачу в проект:<br> "{{ $project->name }}"</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('tasks.store') }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{ $project->id }}"> {{-- Скрытое поле с ID проекта --}}
            <div class="mb-3">
                <label for="title" class="form-label">Название задачи</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание задачи</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="assigned_to_id" class="form-label">Назначить</label>
                <select class="form-select" id="assigned_to_id" name="assigned_to_id">
                    <option value="">Не назначено</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('assigned_to_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="status_id" class="form-label">Статус</label>
                <select class="form-select" id="status_id" name="status_id" required>
                    <option value="">Выберите статус</option>
                    @foreach ($taskStatuses as $status)
                        <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="due_date" class="form-label">Срок выполнения</label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Создать задачу</button>
                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">Отмена</a>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>