<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div style="width:100%; padding: 1.5rem 2rem 0 2rem; display: flex; justify-content: space-between; align-items: center;">
        <h1 style="margin: 0; text-align: left;">
            <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
        </h1>
        <div style="display: flex; align-items: center; gap: 0.5rem; min-width: 0;">
            @php
                $role = Auth::user()->role;
                $color = match($role) {
                    'admin' => '#FF9800',      // laranja
                    'organizer' => '#2563eb',  // azul
                    default => '#222',         // preto para user
                };
            @endphp
            <span style="font-weight: bold; color: {{ $color }};">
                {{ Auth::user()->name }}
            </span>
            <form method="POST" action="{{ route('logout') }}" style="display:inline; background:none; box-shadow:none; padding:0; border:none;">
                @csrf
                <button type="submit" style="background:#FF6B6B; color:#fff; border:none; border-radius:8px; padding:7px 18px; font-weight:bold; font-size:1rem; cursor:pointer;">
                    Sair
                </button>
            </form>
        </div>
    </div>

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