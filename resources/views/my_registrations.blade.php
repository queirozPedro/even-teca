<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <!-- Use .my-registrations-header, .my-registrations-list, etc -->
</head>
<body>
    <div style="width:100%; padding: 1.5rem 2rem 0 2rem;">
        <h1 style="margin: 0; text-align: left;">
            <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
        </h1>
    </div>
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
</body>
</html>