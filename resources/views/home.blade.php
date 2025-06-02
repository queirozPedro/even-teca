<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Eventos</title>
</head>
<body>
    <h1>Bem-vindo, {{ Auth::user()->name }}!</h1>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Sair</button>
    </form>

    <h2>Lista de Eventos</h2>

    @if(session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
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
                    Local: {{ $event->location }}
                </li>
                <hr>
            @endforeach
        </ul>
    @endif
</body>
</html>