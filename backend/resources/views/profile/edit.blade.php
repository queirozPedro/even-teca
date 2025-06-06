<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .profile-form {
            max-width: 400px;
            margin: 2rem auto;
            background: #fff;
            padding: 2rem;
            border-radius: 1.2rem;
            box-shadow: 0 4px 24px 0 #2563eb22;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        .profile-form label {
            font-weight: bold;
        }
        .profile-form input {
            width: 100%;
            padding: 0.7rem 1rem;
            border: 1px solid #cbd5e1;
            border-radius: 0.6rem;
            background: #f8fafc;
            margin-top: 0.3rem;
            margin-bottom: 0.7rem;
            transition: border 0.2s;
        }
        .profile-form button {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 0.6rem;
            padding: 0.7rem 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            margin-top: 0.5rem;
        }
        .profile-form button:hover {
            background: #1d4ed8;
            transform: scale(1.03);
        }
    </style>
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
    <form method="POST" action="{{ route('profile.update') }}" class="profile-form">
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