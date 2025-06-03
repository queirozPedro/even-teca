<!DOCTYPE html>
<html>
<head><title>Administração</title></head>
<body>
    <h1>Painel Administrativo</h1>

    {{-- Usuários --}}
    <h2>Usuários</h2>
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

    {{-- Editar usuário --}}
    @isset($editUser)
        <h2>Editar Usuário</h2>
        <form method="POST" action="{{ route('admin.users.update', $editUser) }}">
            @csrf @method('PUT')
            <div>
                <label>Nome:</label>
                <input type="text" name="name" value="{{ old('name', $editUser->name) }}" required>
            </div>
            <div>
                <label>Email:</label>
                <input type="email" name="email" value="{{ old('email', $editUser->email) }}" required>
            </div>
            <div>
                <label>Tipo:</label>
                <select name="role" required>
                    <option value="user" {{ $editUser->role == 'user' ? 'selected' : '' }}>Usuário</option>
                    <option value="organizer" {{ $editUser->role == 'organizer' ? 'selected' : '' }}>Organizador</option>
                    <option value="admin" {{ $editUser->role == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
            <button type="submit">Salvar</button>
        </form>
    @endisset

    {{-- Eventos --}}
    <h2>Eventos</h2>
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

    {{-- Relatórios --}}
    <h2>Relatórios</h2>
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
            <td>{{ $event->users_count ?? $event->users->count() }}</td>
        </tr>
        @endforeach
    </table>

    <a href="{{ url('/home') }}">Voltar</a>
</body>
</html>