<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Perfil</title>
</head>
<body>
    <h1>Editar Perfil</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('profile.update') }}">
        @csrf
        <div>
            <label>Nome:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required>
        </div>
        <div>
            <label>E-mail:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>
        <div>
            <label>Nova senha:</label>
            <input type="password" name="password">
        </div>
        <div>
            <label>Confirme a nova senha:</label>
            <input type="password" name="password_confirmation">
        </div>
        <button type="submit">Salvar</button>
    </form>
    <a href="{{ url('/home') }}">Voltar</a>
</body>
</html>