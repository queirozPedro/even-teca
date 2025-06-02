<!DOCTYPE html>
<html>
<head><title>Eventos</title></head>
<body>
    <h1>Todos os Eventos</h1>
    <table border="1">
        <tr>
            <th>ID</th><th>Título</th><th>Organizador</th><th>Inscritos</th>
        </tr>
        @foreach($events as $event)
        <tr>
            <td>{{ $event->id }}</td>
            <td>{{ $event->title }}</td>
            <td>{{ $event->organizer_id }}</td>
            <td>
                <ul>
                @foreach($event->users as $user)
                    <li>{{ $user->name }} ({{ $user->email }}) - Status: {{ $user->pivot->status }}</li>
                @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </table>
    <a href="{{ route('admin.users') }}">Ver usuários</a>
</body>
</html>