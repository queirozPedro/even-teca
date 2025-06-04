<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="home-container">
        <div class="home-header">
            <div class="home-title-area" style="padding-left: 37px; padding-top: 15px;">
                <h1 class="home-event-title" style="text-align: left; margin-left: 0;">
                    <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
                </h1>
            </div>
            <div class="user-right" style="position: absolute; top: 24px; right: 40px;">
                @php
                    $role = Auth::user()->role;
                    $color = match($role) {
                        'admin' => '#FF9800',
                        'organizer' => '#2563eb',
                        default => '#222',
                    };
                @endphp
                <span class="home-user" style="color: {{ $color }}; margin-right: 10px;">
                    {{ Auth::user()->name }}
                </span>
                <span style="margin: 0 8px;">|</span>
                <a href="{{ route('logout') }}" class="home-btn-logout" style="margin-top: 12px;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <h2 class="home-event-title" style="text-align: center;">Lista de Eventos</h2>

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
    </div>
</body>
</html>