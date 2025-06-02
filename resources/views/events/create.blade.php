<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Novo Evento</title>
</head>
<body>
    <h1>Criar Evento</h1>
    <form method="POST" action="{{ route('events.store') }}">
        @csrf
        <div>
            <label>Título:</label>
            <input type="text" name="title" value="{{ old('title') }}" required>
        </div>
        <div>
            <label>Descrição:</label>
            <textarea name="description">{{ old('description') }}</textarea>
        </div>
        <div>
            <label>Início:</label>
            <input type="datetime-local" name="start_time" value="{{ old('start_time') }}" required>
        </div>
        <div>
            <label>Fim:</label>
            <input type="datetime-local" name="end_time" value="{{ old('end_time') }}">
        </div>
        <div>
            <label>Local:</label>
            <input type="text" name="location" value="{{ old('location') }}">
        </div>
        <button type="submit">Salvar</button>
    </form>
    <a href="{{ route('events.index') }}">Voltar</a>
</body>
</html>