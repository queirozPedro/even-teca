

@extends('layouts.app')

@section('styles')
<style>
    body {
        font-family: 'Inter', Arial, sans-serif;
        background: linear-gradient(120deg, #e0e7ff 0%, #f9fafb 100%);
    }
    .container.mt-5 {
        margin-top: 3rem !important;
        max-width: 800px;
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
    <h2 class="mb-4"><i class="fa-solid fa-money-check-dollar"></i> Histórico de Pagamentos</h2>
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Total gasto: <span style="color:#2563eb;">R$ {{ number_format($total, 2, ',', '.') }}</span></h5>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Evento</th>
                    <th>Data do Pagamento</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->registration->event->title ?? '-' }}</td>
                        <td>{{ $payment->created_at ? $payment->created_at->format('d/m/Y H:i') : '-' }}</td>
                        <td>R$ {{ number_format($payment->amount, 2, ',', '.') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">Nenhum pagamento encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
