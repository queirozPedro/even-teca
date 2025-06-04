<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .my-registrations-header {
            width: 100%;
            padding: 1.5rem 2rem 0 2rem;
        }
        .my-registrations-title {
            margin: 0;
            text-align: left;
        }
        .my-registrations-list {
            list-style: none;
            padding: 0;
        }
        .my-registrations-list li {
            margin-bottom: 1.5rem;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 1.2rem;
        }
        .my-registrations-list hr {
            margin: 1rem 0;
            border: none;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="my-registrations-header">
        <h1 class="my-registrations-title">
            <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
        </h1>
    </div>
    @if($registrations->isEmpty())
        <p>Você não está inscrito em nenhum evento.</p>
    @else
        <ul class="my-registrations-list">
            @foreach($registrations as $registration)
                <li>
                    <strong>{{ $registration->event->title }}</strong><br>
                    {{ $registration->event->description }}<br>
                    Início: {{ $registration->event->start_time->format('d/m/Y H:i') }}<br>
                    Status da inscrição: {{ $registration->status }}
                </li>
                @if(!$loop->last)
                    <hr>
                @endif
            @endforeach
        </ul>
    @endif
</body>
</html>