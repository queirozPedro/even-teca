<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Home - Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <h1>Bem-vindo, {{ Auth::user()->name }}!</h1>
    <p style="text-align:center;">Tipo de usuário: <strong>{{ ucfirst(Auth::user()->role) }}</strong></p>
    <form method="POST" action="{{ route('logout') }}" style="text-align:center; margin-bottom:2rem;">
        @csrf
        <button type="submit">Sair</button>
    </form>

    <h2>Lista de Eventos</h2>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($events->isEmpty())
        <p style="text-align:center;">Nenhum evento cadastrado.</p>
    @else
        <ul style="list-style:none; padding:0;">
            @foreach($events as $event)
                <li style="text-align:center; margin-bottom:2rem;">
                    <strong>{{ $event->title }}</strong><br>
                    {{ $event->description }}<br>
                    Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                    @if($event->end_time)
                        Fim: {{ $event->end_time->format('d/m/Y H:i') }}<br>
                    @endif
                    Local: {{ $event->location }}<br>

                    @if(Auth::user()->isUser())
                        @if(!Auth::user()->events->contains($event->id))
                            <form method="POST" action="{{ route('events.subscribe', $event) }}" style="display:inline-block; margin-top:0.5rem;">
                                @csrf
                                <button type="submit">Inscrever-se</button>
                            </form>
                        @else
                            <form method="POST" action="{{ route('events.unsubscribe', $event) }}" style="display:inline-block; margin-top:0.5rem;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Cancelar inscrição</button>
                            </form>
                        @endif
                    @endif

                    @can('manage-events')
                        <div style="margin-top:0.5rem;">
                            <a href="{{ route('events.edit', $event) }}">Editar</a>
                            <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Excluir</button>
                            </form>
                            <a href="{{ route('events.attendees', $event) }}">Gerenciar inscritos</a>
                        </div>
                    @endcan
                </li>
                <hr>
            @endforeach
        </ul>
    @endif

    <div style="text-align:center; margin-top:2rem;">
        <a href="{{ route('events.index') }}">Gerenciar eventos</a> |
        <a href="{{ route('my.registrations') }}">Meus eventos inscritos</a> |
        <a href="{{ route('profile.edit') }}">Editar perfil</a>
    </div>
</body>
</html>