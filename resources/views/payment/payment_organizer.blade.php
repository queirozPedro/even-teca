@extends('layouts.app')

@section('styles')
<style>
    body {
        font-family: 'Inter', Arial, sans-serif;
        background: linear-gradient(120deg, #e0e7ff 0%, #f9fafb 100%);
    }
    .container.mt-5 {
        margin-top: 3rem !important;
        max-width: 900px;
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px #0002;
        padding: 2.5rem 2rem 2rem 2rem;
    }
    h2.mb-4 {
        color: #2563eb;
        font-weight: bold;
        font-size: 1.7rem;
        display: flex;
        align-items: center;
        gap: 0.7rem;
    }
    .card.mb-4 {
        border: none;
        border-radius: 12px;
        box-shadow: 0 2px 12px #2563eb11;
        margin-bottom: 2rem !important;
    }
    .card-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #334155;
    }
    .card-title span {
        color: #2563eb;
        font-size: 1.3rem;
    }
    .report-section {
        margin-bottom: 2.5rem;
        background: #f9fafb;
        border-radius: 14px;
        box-shadow: 0 2px 12px #2563eb11;
        padding: 1.5rem 2rem;
    }
    .report-title {
        color: #2563eb;
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    .report-list {
        list-style: none;
        padding: 0;
        margin: 0;
        color: #334155;
        font-size: 1.05rem;
    }
    .report-list li {
        margin-bottom: 0.5rem;
    }
    .report-highlight {
        color: #2563eb;
        font-weight: bold;
    }
    .report-bad {
        color: #b91c1c;
        font-weight: bold;
    }
    .table-responsive {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 12px #2563eb11;
        background: #f9fafb;
    }
    table.table {
        margin-bottom: 0;
        background: #f9fafb;
    }
    thead th {
        background: #e0e7ff;
        color: #2563eb;
        font-weight: bold;
        border-bottom: 2px solid #2563eb22 !important;
        font-size: 1.05rem;
    }
    tbody tr {
        transition: background 0.2s;
    }
    tbody tr:hover {
        background: #e0e7ff55;
    }
    tbody td {
        color: #334155;
        font-size: 1rem;
        vertical-align: middle;
    }
    tbody td:last-child {
        font-weight: bold;
        color: #2563eb;
    }
    .text-center {
        text-align: center !important;
        color: #b91c1c;
        font-weight: bold;
    }
    @media (max-width: 900px) {
        .container.mt-5 {
            padding: 1rem 0.5rem;
        }
        .table-responsive {
            font-size: 0.95rem;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <h2 class="mb-4"><i class="fa-solid fa-money-check-dollar"></i> Histórico de Ganhos</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Total recebido: <span style="color:#2563eb;">R$ {{ number_format($total, 2, ',', '.') }}</span></h5>
        </div>
    </div>
    {{-- Relatórios e análises --}}
    <div class="report-section">
        <div class="report-title"><i class="fa-solid fa-chart-line"></i> Relatórios e Análises</div>
        @php
            $eventStats = collect($events)->map(function($event) {
                $payments = $event->registrations->pluck('payment')->filter();
                $total = 0;
                foreach($payments as $payment) { $total += $payment->amount; }
                return [
                    'title' => $event->title,
                    'count' => $payments->count(),
                    'total' => $total,
                ];
            });
            $mostEarned = $eventStats->sortByDesc('total')->first();
            $leastEarned = $eventStats->sortBy('total')->first();
            $mostRegistered = $eventStats->sortByDesc('count')->first();
            $leastRegistered = $eventStats->sortBy('count')->first();
        @endphp
        <ul class="report-list">
            @if($mostEarned)
                <li>Evento com <span class="report-highlight">maior ganho</span>: <b>{{ $mostEarned['title'] }}</b> (R$ {{ number_format($mostEarned['total'], 2, ',', '.') }})</li>
            @endif
            @if($leastEarned && $leastEarned['total'] < $mostEarned['total'])
                <li>Evento com <span class="report-bad">menor ganho</span>: <b>{{ $leastEarned['title'] }}</b> (R$ {{ number_format($leastEarned['total'], 2, ',', '.') }})</li>
            @endif
            @if($mostRegistered)
                <li>Evento com <span class="report-highlight">mais inscritos</span>: <b>{{ $mostRegistered['title'] }}</b> ({{ $mostRegistered['count'] }} inscrições)</li>
            @endif
            @if($leastRegistered && $leastRegistered['count'] < $mostRegistered['count'])
                <li>Evento com <span class="report-bad">menos inscritos</span>: <b>{{ $leastRegistered['title'] }}</b> ({{ $leastRegistered['count'] }} inscrições)</li>
            @endif
        </ul>
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
