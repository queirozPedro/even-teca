@php
    if (!function_exists('registrationStatusPt')) {
        function registrationStatusPt($status) {
            return match ($status) {
                'pending' => 'Pendente',
                'completed' => 'Confirmado',
                'canceled' => 'Cancelado',
                'pendente' => 'Pendente',
                'confirmado' => 'Confirmado',
                'cancelado' => 'Cancelado',
                default => ucfirst($status),
            };
        }
    }
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento (Organizador)</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .eventos-centralizada {
            max-width: 700px;
            margin: 2rem auto;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            box-shadow: 0 2px 12px #0001;
        }
        .evento-detalhes {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .btn-primario {
            background: #3366FF;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
            border: none;
            cursor: pointer;
        }
        .btn-primario:hover {
            background: #174ea6;
            transform: scale(1.04);
        }
        .btn-delete {
            background: #fee2e2;
            color: #b91c1c;
        }
        .btn-delete:hover {
            background: #b91c1c;
            color: #fff;
        }
        .btn-editar {
            background: #fbbf24;
            color: #fff;
        }
        .btn-editar:hover {
            background: #b45309;
            color: #fff;
        }
        .btn-participantes {
            background: #22c55e;
            color: #fff;
        }
        .btn-participantes:hover {
            background: #15803d;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="eventos-centralizada">
        <h2 class="home-event-title" style="text-align:center;">{{ $event->title }}</h2>
        <div class="evento-detalhes">
            <p><strong>Categoria:</strong> {{ $event->category }}</p>
            <p><strong>Descrição:</strong> {{ $event->description }}</p>
            <p><strong>Início:</strong> {{ $event->start_time->format('d/m/Y H:i') }}</p>
            @if($event->end_time)
                <p><strong>Fim:</strong> {{ $event->end_time->format('d/m/Y H:i') }}</p>
            @endif
            <p><strong>Local:</strong> {{ $event->location }}</p>
            <p><strong>Capacidade:</strong> {{ $event->capacity }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($event->price, 2, ',', '.') }}</p>
        </div>
        <div style="margin-top:2rem; text-align:center;">
            <a href="{{ route('events.edit', $event) }}" class="btn-primario btn-editar">Editar Evento</a>
            <form method="POST" action="{{ route('events.destroy', $event) }}" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-primario btn-delete" onclick="return confirm('Tem certeza que deseja excluir este evento?')">Excluir Evento</button>
            </form>
            <a href="{{ route('events.attendees', $event) }}" class="btn-primario btn-participantes">Ver Participantes</a>
            <a href="{{ url('/home/organizer') }}" class="btn-primario" style="background:#888;">Voltar</a>
        </div>
    </div>
</body>
</html>
