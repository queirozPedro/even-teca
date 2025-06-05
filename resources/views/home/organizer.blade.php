<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>EvenTeca</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', Arial, sans-serif;
            background: linear-gradient(120deg, #e0e7ff 0%, #f9fafb 100%);
        }
        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 60px;
            background: #fff;
            box-shadow: 0 2px 8px #0001;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 2000;
            padding: 0 2rem;
        }
        .header .logo {
            font-size: 1.7rem;
            font-weight: bold;
            color: #2563eb;
            letter-spacing: 1px;
        }
        .header .user-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .header .user-actions span {
            font-weight: bold;
            color: #2563eb;
        }
        .header .user-actions a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
            margin-left: 0.5rem;
            transition: color 0.2s;
        }
        .header .user-actions a:hover {
            color: #1d4ed8;
        }
        .main-layout {
            display: flex;
            min-height: 100vh;
            width: 100vw;
            padding-top: 60px;
        }
        .sidebar-left {
            flex: 1 1 14.285%;
            background: linear-gradient(160deg, #e0e7ff 60%, #c7d2fe 100%);
            min-width: 100px;
            max-width: 220px;
            padding: 2rem 1rem 0.5rem 1rem;
            box-sizing: border-box;
            position: sticky;
            left: 0;
            top: 60px;
            height: calc(100vh - 60px);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            gap: 1.5rem;
        }
        .sidebar-left a, .sidebar-left .btn-primario {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.1rem;
        }
        .sidebar-left a {
            color: #2563eb;
            font-weight: bold;
            text-decoration: none;
            transition: color 0.2s;
        }
        .sidebar-left a:hover {
            color: #1d4ed8;
        }
        .main-center {
            flex: 1 1 auto;
            background: #f9fafb;
            padding: 2.5rem 2.5rem 2rem 2.5rem;
            min-width: 0;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        @media (max-width: 900px) {
            .main-layout {
                flex-direction: column;
                padding-top: 60px;
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
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }
        .event-card {
            background: #fff;
            border-radius: 18px;
            box-shadow: 0 4px 24px #0002;
            padding: 0;
            text-align: left;
            display: flex;
            flex-direction: column;
            min-height: 320px;
            transition: box-shadow 0.2s, transform 0.1s, border 0.2s;
            cursor: pointer;
            border: 2px solid transparent;
            position: relative;
            overflow: hidden;
        }
        .event-card:hover {
            box-shadow: 0 8px 32px #2563eb33;
            border: 2px solid #2563eb;
            transform: translateY(-4px) scale(1.01);
        }
        .event-card .event-banner {
            width: 100%;
            height: 120px;
            background: linear-gradient(90deg, #c7d2fe 60%, #e0e7ff 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color: #2563eb;
        }
        .event-card .event-content {
            padding: 1.2rem 1.5rem 1.2rem 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0.7rem;
        }
        .event-card .event-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 0.2rem;
        }
        .event-card .event-description {
            color: #334155;
            font-size: 1rem;
            margin-bottom: 0.2rem;
        }
        .event-card .event-info {
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem;
            font-size: 0.98rem;
            color: #475569;
            margin-bottom: 0.2rem;
        }
        .event-card .event-info span {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        .event-card .event-actions {
            margin-top: 1rem;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        .event-card .event-actions a {
            font-size: 0.98rem;
            font-weight: bold;
            color: #2563eb;
            text-decoration: none;
            padding: 0.4rem 1rem;
            border-radius: 6px;
            background: #e0e7ff;
            transition: background 0.2s, color 0.2s;
        }
        .event-card .event-actions a:hover {
            background: #2563eb;
            color: #fff;
        }
        .event-card .event-actions .delete {
            color: #b91c1c;
            background: #fee2e2;
        }
        .event-card .event-actions .delete:hover {
            background: #b91c1c;
            color: #fff;
        }
        .event-card .event-actions .attendees {
            color: #22c55e;
            background: #dcfce7;
        }
        .event-card .event-actions .attendees:hover {
            background: #22c55e;
            color: #fff;
        }
        .home-event-title {
            text-align: center;
            margin: 0.5rem 0 0.5rem 0;
            font-size: 1.7rem;
            font-weight: bold;
            color: #2563eb;
        }
        .main-center > .home-event-title {
            margin-top: 0.5rem;
            margin-bottom: 1.2rem;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo"><i class="fa-solid fa-calendar-days"></i> EvenTeca</div>
        <div>
            <a href="{{ url('/home/organizer') }}" class="btn-primario" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #2563eb; background: none; border: none; font-size: 1.1rem; text-decoration: none; padding: 0; box-shadow: none; margin-right: 1.5rem;"><i class="fa-solid fa-house"></i> Início</a>
            <a href="#" id="openCreateEventModal" class="btn-primario" style="display: inline-flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #2563eb; background: none; border: none; font-size: 1.1rem; text-decoration: none; padding: 0; box-shadow: none;"><i class="fa-solid fa-plus"></i> Novo Evento</a>
        </div>
        <div style="display: flex; align-items: center; gap: 2rem;">
            <div class="user-actions">
                <span><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span>
                <a href="{{ route('profile.edit') }}"><i class="fa-solid fa-user-pen"></i> Editar Perfil</a>
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
    <div class="main-layout">
        <!-- Centro -->
        <div class="main-center" style="width:100vw;">
            <h2 class="home-event-title" style="text-align: center;">Meus Eventos Cadastrados</h2>
            @if($events->isEmpty())
                <p style="text-align:center;">Você ainda não cadastrou eventos.</p>
            @else
                <ul class="event-grid">
                    @foreach($events as $event)
                        <li class="event-card">
                            <div class="event-banner">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="event-content">
                                <div class="event-title">{{ $event->title }}</div>
                                <div class="event-description">{{ $event->description }}</div>
                                <div class="event-info">
                                    <span><i class="fa-solid fa-clock"></i> {{ $event->start_time->format('d/m/Y H:i') }}</span>
                                    @if($event->end_time)
                                    <span><i class="fa-solid fa-hourglass-end"></i> {{ $event->end_time->format('d/m/Y H:i') }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-location-dot"></i> {{ $event->location }}</span>
                                    @if($event->capacity)
                                    <span><i class="fa-solid fa-users"></i> {{ $event->capacity }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-money-bill-wave"></i> R$ {{ number_format($event->price, 2, ',', '.') }}</span>
                                </div>
                                <div class="event-actions">
                    <a href="#" class="edit-event-btn" data-id="{{ $event->id }}" data-title="{{ $event->title }}" data-description="{{ $event->description }}" data-start_time="{{ $event->start_time->format('Y-m-d\TH:i') }}" data-end_time="{{ optional($event->end_time)->format('Y-m-d\TH:i') }}" data-location="{{ $event->location }}" data-capacity="{{ $event->capacity }}" data-price="{{ $event->price }}"><i class="fa-solid fa-pen-to-square"></i> Editar</a>
                    <a href="{{ route('events.destroy', $event) }}" class="delete" onclick="event.preventDefault(); if(confirm('Tem certeza que deseja excluir este evento?')){ document.getElementById('delete-event-{{ $event->id }}').submit(); }"><i class="fa-solid fa-trash"></i> Excluir</a>
                    <a href="#" class="attendees-btn" data-event-id="{{ $event->id }}" style="color:#22c55e; background:#dcfce7;"><i class="fa-solid fa-users"></i> Visualizar Participantes</a>
                    <form id="delete-event-{{ $event->id }}" action="{{ route('events.destroy', $event) }}" method="POST" style="display:none;">
                         @csrf
                         @method('DELETE')
                    </form>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
            <!-- Modal de edição de evento -->
        <!-- Modal de inscritos do evento -->
        <div id="attendeesModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,41,59,0.5); z-index:1000; align-items:center; justify-content:center;">
            <div id="attendeesModalContent" style="background:#fff; border-radius:1rem; padding:2rem; min-width:320px; max-width:90vw; max-height:90vh; box-shadow:0 6px 32px #0003; position:relative; overflow-y:auto;">
                <button type="button" onclick="closeAttendeesModal()" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
                <div id="attendees-list-content">Carregando...</div>
            </div>
        </div>
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
        function closeAttendeesModal() {
            document.getElementById('attendeesModal').style.display = 'none';
            document.getElementById('attendees-list-content').innerHTML = '';
        }
        document.querySelectorAll('.attendees-btn').forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const eventId = this.dataset.eventId;
                document.getElementById('attendees-list-content').innerHTML = 'Carregando...';
                document.getElementById('attendeesModal').style.display = 'flex';
                fetch(`/events/${eventId}/attendees`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById('attendees-list-content').innerHTML = html;
                    })
                    .catch(() => {
                        document.getElementById('attendees-list-content').innerHTML = 'Erro ao carregar inscritos.';
                    });
            });
        });
        document.getElementById('attendeesModal').addEventListener('click', function(e) {
            if (e.target === this) closeAttendeesModal();
        });
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

    </div>
</body>
</html>