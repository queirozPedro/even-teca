<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento</title>
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

        .home-event-title {
            text-align: center;
            margin-bottom: 2rem;
            font-size: 1.7rem;
            font-weight: bold;
            color: #2563eb;
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
        }
        .btn-primario:hover {
            background: #174ea6;
            transform: scale(1.04);
        }
    </style>
</head>
<body>
    <div class="eventos-centralizada">
        <h2 class="home-event-title" style="text-align:center;">{{ $showEvent->title }}</h2>
        <div class="evento-detalhes">
            <p><strong>Descrição:</strong> {{ $showEvent->description }}</p>
            <p><strong>Início:</strong> {{ $showEvent->start_time->format('d/m/Y H:i') }}</p>
            @if($showEvent->end_time)
                <p><strong>Fim:</strong> {{ $showEvent->end_time->format('d/m/Y H:i') }}</p>
            @endif
            <p><strong>Local:</strong> {{ $showEvent->location }}</p>
            <p><strong>Capacidade:</strong> {{ $showEvent->capacity }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($showEvent->price, 2, ',', '.') }}</p>
        </div>
        <div style="margin-top:2rem; text-align:center;">
            <a href="{{ route('events.index') }}" class="btn-primario" style="background:#888;">Voltar</a>
        </div>
    </div>
</body>
</html>