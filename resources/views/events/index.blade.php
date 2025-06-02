<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
</head>
<body>
    <h1>Eventos</h1>
    <a href="{{ route('events.create') }}">Novo Evento</a>
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if($events->isEmpty())
        <p>Nenhum evento cadastrado.</p>
    @else
        <ul>
            @foreach($events as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    {{ $event->description }}<br>
                    Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                    @if($event->end_time)
                        Fim: {{ $event->end_time->format('d/m/Y H:i') }}<br>
                    @endif
                    Local: {{ $event->location }}<br>
                    <a href="{{ route('events.show', $event) }}">Ver</a> |
                    @can('manage-events')
                        <a href="{{ route('events.edit', $event) }}">Editar</a> |
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                    @endcan
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
    <a href="{{ url('/home') }}">Voltar para Home</a>
</body>
</html>