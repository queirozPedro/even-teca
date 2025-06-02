<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Meus Eventos Inscritos</title>
</head>
<body>
    <h1>Meus Eventos Inscritos</h1>
    @if($events->isEmpty())
        <p>Você não está inscrito em nenhum evento.</p>
    @else
        <ul>
            @foreach($events as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    {{ $event->description }}<br>
                    Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                    Status da inscrição: {{ $event->pivot->status }}
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
    <a href="{{ url('/home') }}">Voltar para Home</a>
</body>
</html>