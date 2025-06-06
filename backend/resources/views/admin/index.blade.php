<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .admin-header {
            width: 100%;
            padding: 1.5rem 2rem 0 2rem;
        }

        .admin-title {
            margin: 0;
            text-align: left;
        }

        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5rem 0;
            background: #fff;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 2px 12px #2563eb11;
        }

        .admin-table th, .admin-table td {
            padding: 0.8rem 1rem;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        .admin-table th {
            background: #e0e7ff;
            color: #1e40af;
            font-weight: 600;
        }

        .admin-table tr:last-child td {
            border-bottom: none;
        }

        .admin-section-title {
            margin-top: 2rem;
            color: #2563eb;
            font-size: 1.3rem;
        }

        .admin-btn {
            background: #2563eb;
            color: #fff;
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            margin-right: 0.5rem;
        }
        .admin-btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <h1 class="admin-title">
            <a href="{{ url('/home') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
        </h1>
    </div>

    <h1>Painel Administrativo</h1>

    {{-- Usuários --}}
    <h2 class="admin-section-title">Usuários</h2>
    @if(session('success')) <div style="color:green">{{ session('success') }}</div> @endif
    <table class="admin-table" border="1">
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
                <a class="admin-btn" href="{{ route('admin.users.edit', $user) }}">Editar</a>
                <form method="POST" action="{{ route('admin.users.delete', $user) }}" style="display:inline;">
                    @csrf @method('DELETE')
                    <button class="admin-btn" type="submit" onclick="return confirm('Excluir?')">Excluir</button>
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
    <h2 class="admin-section-title">Eventos</h2>
    <table class="admin-table" border="1">
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
                @foreach($event->registrations as $registration)
                    <li>
                        {{ $registration->user->name }} ({{ $registration->user->email }}) - Status: {{ $registration->status }}
                    </li>
                @endforeach
                </ul>
            </td>
        </tr>
        @endforeach
    </table>

    {{-- Relatórios --}}
    <h2 class="admin-section-title">Relatórios</h2>
    <table class="admin-table" border="1">
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
            <td>{{ $event->registrations_count ?? $event->registrations->count() }}</td>
        </tr>
        @endforeach
    </table>

    <a href="{{ url('/home') }}">Voltar</a>
</body>
</html>