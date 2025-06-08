<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Detalhes do Evento</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <style>
        .eventos-centralizada {
            max-width: 700px;
            margin: 2rem auto;
            background: #f9f9f9;
            border-radius: 12px;
            padding: 2rem 1.5rem;
            box-shadow: 0 2px 12px #0001;
        }
        .evento-detalhes {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px #0001;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .btn-primario {
            background: #3366FF;
            color: #fff;
            padding: 10px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            display: inline-block;
            transition: background 0.2s, transform 0.1s;
            border: none;
            cursor: pointer;
        }
        .btn-primario:hover {
            background: #174ea6;
            transform: scale(1.04);
        }
        .btn-cancelar {
            background: #fee2e2;
            color: #b91c1c;
        }
        .btn-cancelar:hover {
            background: #b91c1c;
            color: #fff;
        }
        .btn-pagar {
            background: #22c55e;
            color: #fff;
        }
        .btn-pagar:hover {
            background: #15803d;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="eventos-centralizada">
        <h2 class="home-event-title" style="text-align:center;">{{ $event->title }}</h2>
        <div class="evento-detalhes">
            <p><strong>Categoria:</strong> {{ $event->category }}</p>
            <p><strong>Descrição:</strong> {{ $event->description }}</p>
            <p><strong>Início:</strong> {{ $event->start_time->format('d/m/Y H:i') }}</p>
            @if($event->end_time)
                <p><strong>Fim:</strong> {{ $event->end_time->format('d/m/Y H:i') }}</p>
            @endif
            <p><strong>Local:</strong> {{ $event->location }}</p>
            <p><strong>Capacidade:</strong> {{ $event->capacity }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($event->price, 2, ',', '.') }}</p>
        </div>
        <div style="margin-top:2rem; text-align:center;">
            @if($registration)
                <div style="margin-bottom:1rem;">
                    <span>Status da inscrição: <strong>{{ ucfirst($registration->status) }}</strong></span>
                </div>
                @if($registration->status === 'pendente')
                    <form method="POST" action="{{ route('registrations.pay', $registration->id) }}" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-primario btn-pagar">Realizar Pagamento</button>
                    </form>
                @elseif($registration->status === 'confirmado')
                    <form method="POST" action="#" style="display:inline;" onsubmit="alert('Reembolso simulado!'); return false;">
                        <button type="submit" class="btn-primario btn-cancelar">Solicitar Reembolso</button>
                    </form>
                @endif
                <form method="POST" action="{{ route('events.unsubscribe', $event) }}" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-primario btn-cancelar">Cancelar Inscrição</button>
                </form>
            @else
                <button type="button" class="btn-primario" onclick="openPaymentModal()">Inscrever-se</button>
            @endif
            <a href="{{ url('/home/user') }}" class="btn-primario" style="background:#888;">Voltar</a>
        </div>

        <!-- Modal de pagamento -->
        <div id="paymentModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(30,41,59,0.5); z-index:1000; align-items:center; justify-content:center;">
            <div style="background:#fff; border-radius:12px; padding:2rem; max-width:350px; margin:auto; box-shadow:0 2px 12px #0002; text-align:center;">
                <h3 style="margin-bottom:1.5rem;">Escolha o método de pagamento</h3>
                <form id="paymentForm" method="POST" action="{{ route('events.subscribe', $event) }}">
                    @csrf
                    <div style="margin-bottom:1.2rem; text-align:left;">
                        <label><input type="radio" name="payment_method" value="credit_card" checked> Cartão de Crédito</label><br>
                        <label><input type="radio" name="payment_method" value="pix"> Pix</label><br>
                        <label><input type="radio" name="payment_method" value="boleto"> Boleto</label>
                    </div>
                    <button type="submit" class="btn-primario btn-pagar" style="width:100%;">Pagar e Inscrever-se</button>
                </form>
                <button onclick="closePaymentModal()" class="btn-primario" style="background:#888; margin-top:1rem;">Cancelar</button>
            </div>
        </div>
        <script>
            function openPaymentModal() {
                document.getElementById('paymentModal').style.display = 'flex';
            }
            function closePaymentModal() {
                document.getElementById('paymentModal').style.display = 'none';
            }
            // Fecha modal ao clicar fora
            document.addEventListener('click', function(e) {
                var modal = document.getElementById('paymentModal');
                if (modal && e.target === modal) closePaymentModal();
            });
        </script>
    </div>
</body>
</html>
