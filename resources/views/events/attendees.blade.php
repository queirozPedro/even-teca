<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Inscritos no Evento</title>
</head>
<body>
    <h1>Inscritos em {{ $event->title }}</h1>
    <ul>
        <?php foreach($attendees as $user): ?>
            <li>
                {{ $user->name }} ({{ $user->email }}) - Status: {{ $user->pivot->status }}
                <?php if($user->pivot->status === 'pending'): ?>
                    <form method="POST" action="{{ route('events.approve', [$event, $user->id]) }}" style="display:inline;">
                        @csrf
                        <button type="submit">Aprovar</button>
                    </form>
                    <form method="POST" action="{{ route('events.reject', [$event, $user->id]) }}" style="display:inline;">
                        @csrf
                        <button type="submit">Rejeitar</button>
                    </form>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <a href="{{ route('events.index') }}">Voltar</a>
</body>
</html>