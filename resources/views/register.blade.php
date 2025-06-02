<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
</head>
<body>
    <h1>Cadastro</h1>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div>
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Confirme a senha:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
        </div>
        <div>
            <label for="role">Tipo de usuário:</label>
            <select name="role" id="role" required>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Usuário</option>
                <option value="organizer" {{ old('role') == 'organizer' ? 'selected' : '' }}>Organizador</option>
            </select>
        </div>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="{{ route('login') }}">Voltar para login</a>
</body>
</html>