<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatórios de Eventos</title>
</head>
<body>
    <h1>Relatório: Inscritos por Evento</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Organizador</th>
            <th>Inscritos</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->organizer_id }}</td>
            <td>{{ $event->users_count }}</td>
        </tr>
        @endforeach
    </table>
    <a href="{{ url('/home') }}">Voltar</a>
</body>
</html>