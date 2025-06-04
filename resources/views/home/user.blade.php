<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca - Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
</head>
<body>
    <div class="main-layout">
        <div class="sidebar-left">
            <h1 class="home-event-title">
                <a href="{{ url('/home/user') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
            </h1>
        </div>
        <div class="main-center">
            <h2 class="home-event-title">Eventos Disponíveis</h2>
            @if($eventsDisponiveis->isEmpty())
                <p>Nenhum evento disponível para inscrição.</p>
            @else
                <ul class="event-grid">
                    @foreach($eventsDisponiveis as $event)
                        <li class="event-card">
                            <div>
                                <strong>{{ $event->title }}</strong>
                                <p>{{ $event->description }}</p>
                                <small>{{ $event->start_time }} - {{ $event->location }}</small>
                            </div>
                            <form method="POST" action="{{ route('registrations.store', $event->id) }}">
                                @csrf
                                <button type="submit">Inscrever-se</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            @endif

            <h2 class="home-event-title" style="margin-top:2rem;">Minhas Inscrições</h2>
            @if($registrations->isEmpty())
                <p>Você ainda não está inscrito em nenhum evento.</p>
            @else
                <ul class="event-grid">
                    @foreach($registrations as $registration)
                        <li class="event-card">
                            <div>
                                <strong>{{ $registration->event->title }}</strong>
                                <p>{{ $registration->event->description }}</p>
                                <small>{{ $registration->event->start_time }} - {{ $registration->event->location }}</small>
                            </div>
                            <span>Status: {{ $registration->status }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <div class="sidebar-right"></div>
    </div>
</body>
</html>