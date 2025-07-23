<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Создать новый проект</title>
    <link href="public/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f0f2f5; min-height: 100vh; display: flex; justify-content: center; align-items: center; }
        .card { width: 100%; max-width: 600px; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { color: #007bff; }
    </style>
</head>
<body>
    <div class="card">
        <h1 class="text-center mb-4">Создать новый проект</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Название проекта</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Описание проекта</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="mb-3">
                <label for="owner_id" class="form-label">Владелец проекта</label>
                <select class="form-select" id="owner_id" name="owner_id" required>
                    <option value="">Выберите владельца</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('owner_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-lg">Создать проект</button>
                <a href="{{ route('home') }}" class="btn btn-secondary btn-lg">Отмена</a>
            </div>
        </form>
    </div>
</body>
</html>