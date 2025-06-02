<!DOCTYPE html>
<html>
<head><title>Editar Usuário</title></head>
<body>
    <h1>Editar Usuário</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}">
        @csrf @method('PUT')
        <div>
            <label>Nome:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div>
            <label>Email:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div>
            <label>Tipo:</label>
            <select name="role" required>
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Usuário</option>
                <option value="organizer" {{ $user->role == 'organizer' ? 'selected' : '' }}>Organizador</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>
        <button type="submit">Salvar</button>
    </form>
    <a href="{{ route('admin.users') }}">Voltar</a>
</body>
</html>