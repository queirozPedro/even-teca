@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4"><i class="fa-solid fa-money-check-dollar"></i> Histórico de Ganhos</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Total recebido: <span style="color:#2563eb;">R$ {{ number_format($total, 2, ',', '.') }}</span></h5>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Pagamentos Recebidos</th>
                    <th>Valor Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $event)
                    @php
                        $eventTotal = 0;
                        $payments = $event->registrations->pluck('payment')->filter();
                        foreach($payments as $payment) { $eventTotal += $payment->amount; }
                    @endphp
                    <tr>
                        <td>{{ $event->title }}</td>
                        <td>{{ $payments->count() }}</td>
                        <td>R$ {{ number_format($eventTotal, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhum evento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
