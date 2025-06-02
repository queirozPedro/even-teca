<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Evento</title>
</head>
<body>
    <h1>Editar Evento</h1>
    <form method="POST" action="{{ route('events.update', $event) }}">
        @csrf
        @method('PUT')
        <div>
            <label>Título:</label>
            <input type="text" name="title" value="{{ old('title', $event->title) }}" required>
        </div>
        <div>
            <label>Descrição:</label>
            <textarea name="description">{{ old('description', $event->description) }}</textarea>
        </div>
        <div>
            <label>Início:</label>
            <input type="datetime-local" name="start_time" value="{{ old('start_time', $event->start_time->format('Y-m-d\TH:i')) }}" required>
        </div>
        <div>
            <label>Fim:</label>
            <input type="datetime-local" name="end_time" value="{{ old('end_time', optional($event->end_time)->format('Y-m-d\TH:i')) }}">
        </div>
        <div>
            <label>Local:</label>
            <input type="text" name="location" value="{{ old('location', $event->location) }}">
        </div>
        <button type="submit">Atualizar</button>
    </form>
    <a href="{{ route('events.index') }}">Voltar</a>
</body>
</html>