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
                    Local: {{ $event->location }}<br>

                    @if(Auth::user()->isUser())
                        @if(!Auth::user()->events->contains($event->id))
                            <form method="POST" action="{{ route('events.subscribe', $event) }}">
                                @csrf
                                <button type="submit">Inscrever-se</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('events.unsubscribe', $event) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Cancelar inscrição</button>
                            </form>
                        @endif
                    @endif

                    @can('manage-events')
                        <a href="{{ route('events.edit', $event) }}">Editar</a>
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Excluir</button>
                        </form>
                        <a href="{{ route('events.attendees', $event) }}">Gerenciar inscritos</a>
                    @endcan
                </li>
                <hr>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('events.index') }}">Gerenciar eventos</a>
    <a href="{{ route('my.registrations') }}">Meus eventos inscritos</a>
    <a href="{{ route('profile.edit') }}">Editar perfil</a>
</body>
</html>