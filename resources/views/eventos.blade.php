<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
</head>
<body>
    <h1>Eventos</h1>
    @can('manage-events')
        <a href="{{ route('events.create') }}">Novo Evento</a>
    @endcan
    @if(session('success'))
        <div style="color: green;">{{ session('success') }}</div>
    @endif
    @if($events->isEmpty())
        <p>Nenhum evento cadastrado.</p>
    @else
        <ul>
            @foreach($events as $event)
                <li>
                    <strong>{{ $event->title }}</strong><br>
                    {{ $event->description }}<br>
                    Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                    @if($event->end_time)
                        Fim: {{ $event->end_time->format('d/m/Y H:i') }}<br>
                    @endif
                    Local: {{ $event->location }}<br>
                    <a href="{{ route('events.show', $event) }}">Ver</a> |
                    @can('manage-events')
                        <a href="{{ route('events.edit', $event) }}">Editar</a> |
                        <form action="{{ route('events.destroy', $event) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Tem certeza?')">Excluir</button>
                        </form>
                        <a href="{{ route('events.attendees', $event) }}">Gerenciar inscritos</a>
                    @endcan
                </li>
                <hr>
            @endforeach
        </ul>
    @endif

    {{-- Formulário de criar/editar evento --}}
    @if(isset($editEvent) || isset($createEvent))
        <h2>{{ isset($editEvent) ? 'Editar Evento' : 'Criar Evento' }}</h2>
        <form method="POST" action="{{ isset($editEvent) ? route('events.update', $editEvent) : route('events.store') }}">
            @csrf
            @if(isset($editEvent)) @method('PUT') @endif
            <div>
                <label>Título:</label>
                <input type="text" name="title" value="{{ old('title', $editEvent->title ?? '') }}" required>
            </div>
            <div>
                <label>Descrição:</label>
                <textarea name="description">{{ old('description', $editEvent->description ?? '') }}</textarea>
            </div>
            <div>
                <label>Início:</label>
                <input type="datetime-local" name="start_time" value="{{ old('start_time', isset($editEvent) ? $editEvent->start_time->format('Y-m-d\TH:i') : '') }}" required>
            </div>
            <div>
                <label>Fim:</label>
                <input type="datetime-local" name="end_time" value="{{ old('end_time', isset($editEvent) && $editEvent->end_time ? $editEvent->end_time->format('Y-m-d\TH:i') : '') }}">
            </div>
            <div>
                <label>Local:</label>
                <input type="text" name="location" value="{{ old('location', $editEvent->location ?? '') }}">
            </div>
            <div>
                <label>Capacidade:</label>
                <input type="number" name="capacity" value="{{ old('capacity', $editEvent->capacity ?? '') }}">
            </div>
            <div>
                <label>Preço:</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $editEvent->price ?? '0.00') }}">
            </div>
            <div>
                <label>Categoria:</label>
                <input type="text" name="category" value="{{ old('category', $editEvent->category ?? '') }}">
            </div>
            <button type="submit">{{ isset($editEvent) ? 'Atualizar' : 'Salvar' }}</button>
        </form>
    @endif

    {{-- Detalhes do evento --}}
    @isset($showEvent)
        <h2>{{ $showEvent->title }}</h2>
        <p>{{ $showEvent->description }}</p>
        <p>Início: {{ $showEvent->start_time->format('d/m/Y H:i') }}</p>
        @if($showEvent->end_time)
            <p>Fim: {{ $showEvent->end_time->format('d/m/Y H:i') }}</p>
        @endif
        <p>Local: {{ $showEvent->location }}</p>
        @can('manage-events')
            <a href="{{ route('events.edit', $showEvent) }}">Editar</a> |
        @endcan
        <a href="{{ route('events.index') }}">Voltar</a>
    @endisset

    {{-- Inscritos --}}
    @isset($attendees)
        <h2>Inscritos em {{ $attendeesEvent->title }}</h2>
        <ul>
            @foreach($attendees as $user)
                <li>
                    {{ $user->name }} ({{ $user->email }}) - Status: {{ $user->pivot->status }}
                    @if($user->pivot->status === 'pending')
                        <form method="POST" action="{{ route('events.approve', [$attendeesEvent, $user->id]) }}" style="display:inline;">
                            @csrf
                            <button type="submit">Aprovar</button>
                        </form>
                        <form method="POST" action="{{ route('events.reject', [$attendeesEvent, $user->id]) }}" style="display:inline;">
                            @csrf
                            <button type="submit">Rejeitar</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
        <a href="{{ route('events.index') }}">Voltar</a>
    @endisset

    <a href="{{ url('/home') }}">Voltar para Home</a>
</body>
</html>