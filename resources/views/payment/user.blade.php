@extends('layouts.app')

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
