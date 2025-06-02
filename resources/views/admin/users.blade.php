<!DOCTYPE html>
<html>
<head><title>Usuários</title></head>
<body>
    <h1>Usuários</h1>
    @if(session('success')) <div style="color:green">{{ session('success') }}</div> @endif
    <table border="1">
        <tr>
            <th>ID</th><th>Nome</th><th>Email</th><th>Tipo</th><th>Ações</th>
        </tr>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
                <a href="{{ route('admin.users.edit', $user) }}">Editar</a>
                <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Excluir?')">Excluir</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    <a href="{{ route('admin.events') }}">Ver eventos</a>
    <a href="{{ route('admin.reports') }}">Ver Relatórios</a>
    <a href="{{ route('organizer.reports') }}">Ver Relatórios</a>
</body>
</html>