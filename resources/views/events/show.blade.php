<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento</title>
</head>
<body>
    <h1>{{ $event->title }}</h1>
    <p>{{ $event->description }}</p>
    <p>Início: {{ $event->start_time->format('d/m/Y H:i') }}</p>
    @if($event->end_time)
        <p>Fim: {{ $event->end_time->format('d/m/Y H:i') }}</p>
    @endif
    <p>Local: {{ $event->location }}</p>
    @can('manage-events')
        <a href="{{ route('events.edit', $event) }}">Editar</a> |
    @endcan
    <a href="{{ route('events.index') }}">Voltar</a>
</body>
</html>