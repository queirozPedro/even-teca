<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <style>
        .main-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
        }
        .sidebar-left {
            flex: 1 1 14.285%;
            background: #e0e7ff;
            min-width: 100px;
            max-width: 200px;
            padding: 2rem 1rem 0.5rem 1rem;
            box-sizing: border-box;
            position: sticky;
            left: 0;
            top: 0;
            height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
        }
        .main-center {
            flex: 5 1 71.43%;
            background: #f9fafb;
            padding: 2rem 2rem;
            min-width: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar-right {
            flex: 1 1 14.285%;
            background: #e0e7ff;
            min-width: 100px;
            max-width: 200px;
            padding: 2rem 1rem;
            box-sizing: border-box;
        }
        @media (max-width: 900px) {
            .main-layout {
                flex-direction: column;
            }
            .sidebar-left, .sidebar-right {
                max-width: 100vw;
                min-width: 0;
                width: 100vw;
                height: auto;
                position: static;
            }
            .main-center {
                width: 100vw;
                padding: 1rem 0.5rem;
            }
        }
        .event-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }
        .event-card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 12px #0001;
            padding: 1.5rem;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 220px;
            transition: box-shadow 0.2s, transform 0.1s, border 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
        }
        .event-card.selected {
            border: 2px solid #2563eb;
            background: #e0e7ff;
        }
        .event-card label {
            cursor: pointer;
            width: 100%;
            display: block;
        }
        .home-event-title {
            text-align: center;
            margin: 0.5rem 0 0.5rem 0;
            font-size: 1.5rem;
            font-weight: bold;
            color: #2563eb;
        }
        .main-center > .home-event-title {
            margin-top: 0.5rem;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>
    <div class="main-layout">
        <!-- Sidebar esquerda -->
        <div class="sidebar-left">
            <h1 class="home-event-title">
                <a href="{{ url('/home/organizer') }}" style="text-decoration:none; color:inherit;">EvenTeca</a>
            </h1>
            <a href="#" id="openCreateEventModal" class="btn-primario" style="margin-top:2rem; width:100%; text-align:center; display:block;">
                Novo Evento
            </a>
        </div>
        <!-- Centro -->
        <div class="main-center">
            <h2 class="home-event-title" style="text-align: center;">Meus Eventos Cadastrados</h2>
            @if($events->isEmpty())
                <p style="text-align:center;">Você ainda não cadastrou eventos.</p>
            @else
                <ul class="event-grid">
                    @foreach($events as $event)
                        <li class="event-card">
                            <label>
                                <strong>{{ $event->title }}</strong><br>
                                {{ $event->description }}<br>
                                Início: {{ $event->start_time->format('d/m/Y H:i') }}<br>
                            </label>
                            <div style="margin-top:0.5rem;">
                                <a href="#"
                                   class="edit-event-btn"
                                   data-id="{{ $event->id }}"
                                   data-title="{{ $event->title }}"
                                   data-description="{{ $event->description }}"
                                   data-start_time="{{ $event->start_time->format('Y-m-d\TH:i') }}"
                                   data-end_time="{{ optional($event->end_time)->format('Y-m-d\TH:i') }}"
                                   data-location="{{ $event->location }}"
                                   data-capacity="{{ $event->capacity }}"
                                   data-price="{{ $event->price }}">
                                    Editar
                                </a> |
                                <a href="{{ route('events.destroy', $event) }}"
                                    onclick="event.preventDefault(); if(confirm('Tem certeza que deseja excluir este evento?')){ document.getElementById('delete-event-{{ $event->id }}').submit(); }"
                                    style="color: #b91c1c; margin-left: 0.5rem;">
                                     Excluir
                                </a> |
                                <form id="delete-event-{{ $event->id }}" action="{{ route('events.destroy', $event) }}" method="POST" style="display:none;">
                                     @csrf
                                     @method('DELETE')
                                </form>
                                <a href="{{ route('events.attendees', $event) }}">Gerenciar inscritos</a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <!-- Modal de edição de evento -->
            <div id="editEventModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,41,59,0.5); z-index:1000; align-items:center; justify-content:center;">
                <div style="background:#fff; border-radius:1rem; padding:2rem; min-width:320px; max-width:90vw; max-height:90vh; box-shadow:0 6px 32px #0003; position:relative; overflow-y:auto;">
                    <button type="button" onclick="closeEditModal()" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
                    <h2 style="margin-bottom:1rem;">Editar Evento</h2>
                    <form id="editEventForm" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="event_id" id="edit-event-id">
                        <div style="margin-bottom:1rem;">
                            <label for="edit-title">Título:</label>
                            <input type="text" name="title" id="edit-title" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-description">Descrição:</label>
                            <textarea name="description" id="edit-description" class="form-control" required style="width:100%;"></textarea>
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-start_time">Data e Hora de Início:</label>
                            <input type="datetime-local" name="start_time" id="edit-start_time" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-end_time">Data e Hora de Término:</label>
                            <input type="datetime-local" name="end_time" id="edit-end_time" class="form-control" style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-location">Local:</label>
                            <input type="text" name="location" id="edit-location" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-capacity">Capacidade:</label>
                            <input type="number" name="capacity" id="edit-capacity" class="form-control" min="1" style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="edit-price">Preço:</label>
                            <input type="number" step="0.01" name="price" id="edit-price" class="form-control" min="0" style="width:100%;">
                        </div>
                        <button type="submit" class="btn-primario" style="margin-top:1rem;">Salvar Alterações</button>
                    </form>
                </div>
            </div>
            <!-- Modal de criação de evento -->
            <div id="createEventModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,41,59,0.5); z-index:1000; align-items:center; justify-content:center;">
                <div style="background:#fff; border-radius:1rem; padding:2rem; min-width:320px; max-width:90vw; max-height:90vh; box-shadow:0 6px 32px #0003; position:relative; overflow-y:auto;">
                    <button type="button" onclick="closeCreateModal()" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
                    <h2 style="margin-bottom:1rem;">Novo Evento</h2>
                    <form id="createEventForm" method="POST" action="{{ route('events.store') }}">
                        @csrf
                        <div style="margin-bottom:1rem;">
                            <label for="create-title">Título:</label>
                            <input type="text" name="title" id="create-title" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-description">Descrição:</label>
                            <textarea name="description" id="create-description" class="form-control" required style="width:100%;"></textarea>
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-start_time">Data e Hora de Início:</label>
                            <input type="datetime-local" name="start_time" id="create-start_time" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-end_time">Data e Hora de Término:</label>
                            <input type="datetime-local" name="end_time" id="create-end_time" class="form-control" style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-location">Local:</label>
                            <input type="text" name="location" id="create-location" class="form-control" required style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-capacity">Capacidade:</label>
                            <input type="number" name="capacity" id="create-capacity" class="form-control" min="1" style="width:100%;">
                        </div>
                        <div style="margin-bottom:1rem;">
                            <label for="create-price">Preço:</label>
                            <input type="number" step="0.01" name="price" id="create-price" class="form-control" min="0" style="width:100%;">
                        </div>
                        <button type="submit" class="btn-primario" style="margin-top:1rem;">Criar Evento</button>
                    </form>
                </div>
            </div>
            <script>
                function closeEditModal() {
                    document.getElementById('editEventModal').style.display = 'none';
                }
                document.querySelectorAll('.edit-event-btn').forEach(btn => {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        document.getElementById('edit-event-id').value = this.dataset.id;
                        document.getElementById('edit-title').value = this.dataset.title;
                        document.getElementById('edit-description').value = this.dataset.description;
                        document.getElementById('edit-start_time').value = this.dataset.start_time;
                        document.getElementById('edit-end_time').value = this.dataset.end_time || '';
                        document.getElementById('edit-location').value = this.dataset.location;
                        document.getElementById('edit-capacity').value = this.dataset.capacity || '';
                        document.getElementById('edit-price').value = this.dataset.price || '';
                        document.getElementById('editEventForm').action = '/events/' + this.dataset.id;
                        document.getElementById('editEventModal').style.display = 'flex';
                    });
                });
                document.getElementById('editEventModal').addEventListener('click', function(e) {
                    if (e.target === this) closeEditModal();
                });
                function closeCreateModal() {
                    document.getElementById('createEventModal').style.display = 'none';
                }
                document.getElementById('openCreateEventModal').addEventListener('click', function(e) {
                    e.preventDefault();
                    // Limpa os campos do formulário
                    document.getElementById('create-title').value = '';
                    document.getElementById('create-description').value = '';
                    document.getElementById('create-start_time').value = '';
                    document.getElementById('create-end_time').value = '';
                    document.getElementById('create-location').value = '';
                    document.getElementById('create-capacity').value = '';
                    document.getElementById('create-price').value = '';
                    document.getElementById('createEventModal').style.display = 'flex';
                });
                document.getElementById('createEventModal').addEventListener('click', function(e) {
                    if (e.target === this) closeCreateModal();
                });
            </script>
        </div>
        <!-- Sidebar direita -->
        <div class="sidebar-right">
            <div style="font-weight:bold; margin-bottom: 1.5rem;">
                {{ Auth::user()->name }}
            </div>
            <a href="{{ route('profile.edit') }}"
               style="display:block; margin-bottom:1rem; color:#2563eb; font-weight:bold; text-decoration:none;">
                Editar Perfil
            </a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               style="color: #b91c1c; font-weight: bold; text-decoration: none; display: block; margin-top: 1rem; cursor: pointer;">
                Sair
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</body>
</html>