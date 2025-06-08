<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Busca de Eventos</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .event-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(320px, 1fr));
            gap: 2rem;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
            justify-items: center;
        }
        .event-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px #0002;
            padding: 0;
            text-align: left;
            display: flex;
            flex-direction: column;
            min-height: 320px;
        }
        .event-card .event-banner {
            width: 100%;
            height: 120px;
            background: linear-gradient(90deg, #c7d2fe 60%, #e0e7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #2563eb;
        }
        .event-card .event-content {
            padding: 1.2rem 1.5rem 1.2rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }
        .event-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 0.2rem;
        }
        .event-description {
            color: #334155;
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }
        .event-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            font-size: 0.98rem;
            color: #475569;
            margin-bottom: 0.2rem;
        }
    </style>
</head>
<body>
    <div style="width:100%; padding: 1.5rem 2rem 0 2rem;">
        <h1 style="margin: 0; text-align: left;">Resultados da Busca</h1>
        <a href="/home" class="btn-primario" style="margin-top:1rem;">Voltar</a>
    </div>
    @if($events->isEmpty())
        <p style="text-align:center;">Nenhum evento encontrado.</p>
    @else
        <ul class="event-grid">
            @foreach($events as $event)
                <li class="event-card">
                    <div class="event-banner">
                        <i class="fa-solid fa-calendar-check"></i>
                    </div>
                    <div class="event-content">
                        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                            <div class="event-title" style="margin-bottom: 0;">{{ $event->title }}</div>
                            <a href="{{ route('event.user.show', $event->id) }}" class="btn-primario" style="font-size: 0.98rem; padding: 0.3rem 1rem; border-radius: 6px; text-decoration: none;">Ver detalhes</a>
                        </div>
                        <div class="event-description">{{ $event->description }}</div>
                        <div class="event-info">
                            <span><i class="fa-solid fa-tag"></i> {{ $event->category }}</span>
                            <span><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y H:i') }}</span>
                            @if($event->end_time)
                            <span><i class="fa-solid fa-hourglass-end"></i> {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y H:i') }}</span>
                            @endif
                            <span><i class="fa-solid fa-location-dot"></i> {{ $event->location }}</span>
                            @if($event->capacity)
                            <span><i class="fa-solid fa-users"></i> {{ $event->capacity }}</span>
                            @endif
                            <span><i class="fa-solid fa-money-bill-wave"></i> R$ {{ number_format($event->price, 2, ',', '.') }}</span>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</body>
</html>
