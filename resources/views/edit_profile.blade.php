<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div style="width:100%; padding: 1.5rem 2rem 0 2rem;">
        <h1 style="margin: 0; text-align: left;">
            <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
        </h1>
    </div>
    @if ($errors->any())
        <div class="error">
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
    <div style="text-align:center; margin-top:1rem;">
        <a href="{{ url('/home') }}">Voltar</a>
    </div>
</body>
</html>