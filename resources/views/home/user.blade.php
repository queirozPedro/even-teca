<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <title>EvenTeca - Eventos</title>
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
        .sidebar-left a {
            display: flex;
            align-items: center;
            gap: 0.7rem;
            font-size: 1.1rem;
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
            .sidebar-left {
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
            grid-template-columns: repeat(4, minmax(320px, 1fr));
            gap: 2rem;
            list-style: none;
            padding: 0;
            margin: 2rem 0;
        }
        @media (max-width: 1500px) {
            .event-grid {
                grid-template-columns: repeat(3, minmax(320px, 1fr));
            }
        }
        @media (max-width: 1100px) {
            .event-grid {
                grid-template-columns: repeat(2, minmax(320px, 1fr));
            }
        }
        @media (max-width: 700px) {
            .event-grid {
                grid-template-columns: repeat(1, minmax(0, 1fr));
            }
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
            width: 350px;
            max-width: 100%;
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
        .event-card .event-actions button {
            font-size: 0.98rem;
            font-weight: bold;
            color: #fff;
            background: #2563eb;
            border: none;
            border-radius: 6px;
            padding: 0.4rem 1.2rem;
            cursor: pointer;
            transition: background 0.2s;
        }
        .event-card .event-actions button.cancel {
            background: #b91c1c;
        }
        .event-card .event-actions button.cancel:hover {
            background: #991b1b;
        }
        .event-card .event-actions button:hover {
            background: #1d4ed8;
        }
        .event-card .event-status {
            margin-top: 0.7rem;
            font-weight: bold;
            color: #2563eb;
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
        <div style="display: flex; align-items: center; gap: 1.5rem;">
            <a href="{{ url('/home/user') }}" class="btn-primario" style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #2563eb; background: none; border: none; font-size: 1.1rem; text-decoration: none; padding: 0; box-shadow: none;"><i class="fa-solid fa-house"></i> Início</a>
            <a href="{{ route('payments.user') }}" class="btn-primario" style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #2563eb; background: none; border: none; font-size: 1.1rem; text-decoration: none; padding: 0; box-shadow: none;"><i class="fa-solid fa-money-check-dollar"></i> Pagamentos</a>
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
            <h2 class="home-event-title" style="text-align: center;">Eventos Disponíveis</h2>
            @if($eventsDisponiveis->isEmpty())
                <p style="text-align:center;">Nenhum evento disponível para inscrição.</p>
            @else
                <ul class="event-grid">
                    @foreach($eventsDisponiveis as $event)
                        <li class="event-card" onclick="openEventModal({{ $event->id }}, '{{ addslashes($event->title) }}', '{{ addslashes($event->description) }}', '{{ $event->start_time }}', '{{ $event->end_time }}', '{{ addslashes($event->location) }}', '{{ $event->capacity }}', '{{ $event->price }}', false)">
                            <div class="event-banner" onclick="event.stopPropagation(); openEventModal({{ $event->id }}, '{{ addslashes($event->title) }}', '{{ addslashes($event->description) }}', '{{ $event->start_time }}', '{{ $event->end_time }}', '{{ addslashes($event->location) }}', '{{ $event->capacity }}', '{{ $event->price }}', false);">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="event-content" onclick="event.stopPropagation(); openEventModal({{ $event->id }}, '{{ addslashes($event->title) }}', '{{ addslashes($event->description) }}', '{{ $event->start_time }}', '{{ $event->end_time }}', '{{ addslashes($event->location) }}', '{{ $event->capacity }}', '{{ $event->price }}', false);">
                                <div class="event-title">{{ $event->title }}</div>
                                <div class="event-description">{{ $event->description }}</div>
                                <div class="event-info">
                                    <span><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($event->start_time)->format('d/m/Y H:i') }}</span>
                                    @if($event->end_time)
                                    <span><i class="fa-solid fa-hourglass-end"></i> {{ \Carbon\Carbon::parse($event->end_time)->format('d/m/Y H:i') }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-location-dot"></i> {{ $event->location }}</span>
                                    @if($event->capacity)
                                    <span><i class="fa-solid fa-users"></i> {{ $event->capacity }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-money-bill-wave"></i> R$ {{ number_format($event->price, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif

            <h2 class="home-event-title" style="margin-top:2rem; text-align:center;">Minhas Inscrições</h2>
            @if($registrations->isEmpty())
                <p style="text-align:center;">Você ainda não está inscrito em nenhum evento.</p>
            @else
                <ul class="event-grid">
                    @foreach($registrations as $registration)
                        <li class="event-card" onclick="openEventModal({{ $registration->event->id }}, '{{ addslashes($registration->event->title) }}', '{{ addslashes($registration->event->description) }}', '{{ $registration->event->start_time }}', '{{ $registration->event->end_time }}', '{{ addslashes($registration->event->location) }}', '{{ $registration->event->capacity }}', '{{ $registration->event->price }}', true, '{{ $registration->status }}', {{ $registration->id }})">
                            <div class="event-banner" onclick="event.stopPropagation(); openEventModal({{ $registration->event->id }}, '{{ addslashes($registration->event->title) }}', '{{ addslashes($registration->event->description) }}', '{{ $registration->event->start_time }}', '{{ $registration->event->end_time }}', '{{ addslashes($registration->event->location) }}', '{{ $registration->event->capacity }}', '{{ $registration->event->price }}', true, '{{ $registration->status }}', {{ $registration->id }});">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <div class="event-content" onclick="event.stopPropagation(); openEventModal({{ $registration->event->id }}, '{{ addslashes($registration->event->title) }}', '{{ addslashes($registration->event->description) }}', '{{ $registration->event->start_time }}', '{{ $registration->event->end_time }}', '{{ addslashes($registration->event->location) }}', '{{ $registration->event->capacity }}', '{{ $registration->event->price }}', true, '{{ $registration->status }}', {{ $registration->id }});">
                                <div class="event-title">{{ $registration->event->title }}</div>
                                <div class="event-description">{{ $registration->event->description }}</div>
                                <div class="event-info">
                                    <span><i class="fa-solid fa-clock"></i> {{ \Carbon\Carbon::parse($registration->event->start_time)->format('d/m/Y H:i') }}</span>
                                    @if($registration->event->end_time)
                                    <span><i class="fa-solid fa-hourglass-end"></i> {{ \Carbon\Carbon::parse($registration->event->end_time)->format('d/m/Y H:i') }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-location-dot"></i> {{ $registration->event->location }}</span>
                                    @if($registration->event->capacity)
                                    <span><i class="fa-solid fa-users"></i> {{ $registration->event->capacity }}</span>
                                    @endif
                                    <span><i class="fa-solid fa-money-bill-wave"></i> R$ {{ number_format($registration->event->price, 2, ',', '.') }}</span>
                                </div>
                                <div class="event-status">Status: {{ $registration->status }}</div>
                            </div>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
        <!-- Modal de evento para usuário -->
        <div id="eventUserModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,41,59,0.5); z-index:1000; align-items:center; justify-content:center;">
            <div style="background:#fff; border-radius:1rem; padding:2rem; min-width:320px; max-width:90vw; max-height:90vh; box-shadow:0 6px 32px #0003; position:relative; overflow-y:auto;">
                <button type="button" onclick="closeEventModal()" style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.5rem; color:#888; cursor:pointer;">&times;</button>
                <h2 id="event-modal-title" style="margin-bottom:1rem;"></h2>
                <div style="margin-bottom:1rem;">
                    <strong>Descrição:</strong>
                    <div id="event-modal-description"></div>
                </div>
                <div style="margin-bottom:1rem;">
                    <strong>Início:</strong> <span id="event-modal-start"></span>
                </div>
                <div style="margin-bottom:1rem;">
                    <strong>Fim:</strong> <span id="event-modal-end"></span>
                </div>
                <div style="margin-bottom:1rem;">
                    <strong>Local:</strong> <span id="event-modal-location"></span>
                </div>
                <div style="margin-bottom:1rem;">
                    <strong>Capacidade:</strong> <span id="event-modal-capacity"></span>
                </div>
                <div style="margin-bottom:1rem;">
                    <strong>Preço:</strong> R$ <span id="event-modal-price"></span>
                </div>
                <div id="event-modal-status" style="margin-bottom:1rem;"></div>
                <form id="event-modal-action-form" method="POST" style="margin-top:1rem;">
                    @csrf
                    <div id="event-modal-pay-btn-container"></div>
                    <button id="event-modal-action-btn" type="submit" class="btn-primario"></button>
                </form>
            </div>
        </div>

    </div>
</body>
<script>
    function closeEventModal() {
        document.getElementById('eventUserModal').style.display = 'none';
    }
    function openEventModal(id, title, description, start, end, location, capacity, price, isRegistered, status = null, registrationId = null) {
        document.getElementById('event-modal-title').textContent = title;
        document.getElementById('event-modal-description').textContent = description;
        document.getElementById('event-modal-start').textContent = formatDateTime(start);
        document.getElementById('event-modal-end').textContent = end ? formatDateTime(end) : '-';
        document.getElementById('event-modal-location').textContent = location;
        document.getElementById('event-modal-capacity').textContent = capacity || '-';
        document.getElementById('event-modal-price').textContent = price !== 'null' && price !== null ? parseFloat(price).toFixed(2) : '0.00';

        const form = document.getElementById('event-modal-action-form');
        const btn = document.getElementById('event-modal-action-btn');
        const statusDiv = document.getElementById('event-modal-status');
        // Remove _method se existir
        let methodInput = form.querySelector('input[name="_method"]');
        if (methodInput) methodInput.remove();
        // Remove botão de pagamento anterior
        const payBtnContainer = document.getElementById('event-modal-pay-btn-container');
        payBtnContainer.innerHTML = '';
        if (!isRegistered) {
            form.action = '/events/' + id + '/subscribe';
            form.method = 'POST';
            btn.textContent = 'Inscrever-se';
            btn.style.display = '';
            statusDiv.innerHTML = '';
        } else {
            form.action = '/events/' + id + '/unsubscribe';
            form.method = 'POST';
            btn.textContent = 'Cancelar inscrição';
            btn.style.display = '';
            statusDiv.innerHTML = '<span style="font-weight:bold; color:#2563eb;">Status: ' + status + '</span>';
            // Adiciona o método DELETE para o cancelamento
            methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            // Adiciona botões de ação semelhantes aos de editar/excluir
            payBtnContainer.style.display = 'flex';
            payBtnContainer.style.gap = '1rem';
            if (status === 'pendente' && registrationId) {
                const payForm = document.createElement('form');
                payForm.action = '/registrations/' + registrationId + '/pay';
                payForm.method = 'POST';
                payForm.style.width = '100%';
                payForm.style.display = 'flex';
                payForm.style.justifyContent = 'center';
                payForm.style.alignItems = 'center';
                payForm.style.marginBottom = '0.5rem';
                // CSRF token
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                payForm.appendChild(csrfInput);
                const payBtn = document.createElement('button');
                payBtn.type = 'submit';
                payBtn.className = 'btn-primario';
                payBtn.style.background = '#22c55e';
                payBtn.style.color = '#fff';
                payBtn.style.padding = '0.4rem 1.2rem';
                payBtn.style.borderRadius = '6px';
                payBtn.style.fontWeight = 'bold';
                payBtn.style.textDecoration = 'none';
                payBtn.style.transition = 'background 0.2s, color 0.2s';
                payBtn.style.width = '100%';
                payBtn.style.boxSizing = 'border-box';
                payBtn.textContent = 'Realizar Pagamento';
                payBtn.onmouseover = function() { payBtn.style.background = '#15803d'; payBtn.style.color = '#fff'; };
                payBtn.onmouseout = function() { payBtn.style.background = '#22c55e'; payBtn.style.color = '#fff'; };
                payForm.appendChild(payBtn);
                payBtnContainer.appendChild(payForm);
            }
            // Ajusta largura do botão cancelar inscrição igual ao de pagamento
            btn.style.width = '100%';
            btn.style.boxSizing = 'border-box';
            btn.style.minWidth = '';
            btn.style.textAlign = 'center';
            // Estiliza o botão de cancelar inscrição
            btn.className = 'btn-primario';
            btn.style.background = '#fee2e2';
            btn.style.color = '#b91c1c';
            btn.style.padding = '0.4rem 1rem';
            btn.style.borderRadius = '6px';
            btn.style.fontWeight = 'bold';
            btn.style.textDecoration = 'none';
            btn.style.transition = 'background 0.2s, color 0.2s';
            btn.onmouseover = function() { btn.style.background = '#b91c1c'; btn.style.color = '#fff'; };
            btn.onmouseout = function() { btn.style.background = '#fee2e2'; btn.style.color = '#b91c1c'; };
        }
        document.getElementById('eventUserModal').style.display = 'flex';
    }
    function formatDateTime(dt) {
        if (!dt) return '-';
        const d = new Date(dt);
        if (isNaN(d.getTime())) return dt;
        return d.toLocaleString('pt-BR', { day: '2-digit', month: '2-digit', year: 'numeric', hour: '2-digit', minute: '2-digit' });
    }
    document.getElementById('eventUserModal').addEventListener('click', function(e) {
        if (e.target === this) closeEventModal();
    });
</script>
</html>