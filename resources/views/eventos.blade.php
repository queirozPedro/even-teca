<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1 class="titulo-principal">
        <a href="{{ url('/home') }}">EvenTeca</a>
    </h1>

    <h1 class="titulo-pagina">Eventos</h1>

    @if(session('success'))
        <div class="success text-center">{{ session('success') }}</div>
    @endif

    @if($events->isEmpty())
        <p class="text-center">Nenhum evento cadastrado.</p>
    @else
        <div class="eventos-lista-container">
            <ul class="eventos-lista">
                @foreach($events as $event)
                    <li class="evento-item">
                        <strong>{{ $event->title }}</strong><br>
                        {{ $event->description }}<br>
                        Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                        @if($event->end_time)
                            Fim: {{ $event->end_time->format('d/m/Y H:i') }}<br>
                        @endif
                        Local: {{ $event->location }}<br>
                        <a href="{{ route('events.show', $event) }}">Ver</a> |
                        <a href="{{ route('events.edit', $event) }}">Editar</a> |
                        <a href="{{ route('events.delete', $event) }}" class="link-excluir">Excluir</a>
                        | <a href="{{ route('events.attendees', $event) }}">Gerenciar inscritos</a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="novo-evento-container">
        <a href="{{ route('events.create') }}" class="btn-primario">Novo Evento</a>
    </div>
</body>
</html>