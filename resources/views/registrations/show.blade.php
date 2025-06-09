
@extends('layouts.app')

@section('content')
<div class="header" style="position: fixed; top: 0; left: 0; width: 100vw; height: 60px; background: #fff; box-shadow: 0 2px 8px #0001; display: flex; align-items: center; justify-content: space-between; z-index: 2000; padding: 0 2rem;">
    <div class="logo" style="font-size: 1.7rem; font-weight: bold; color: #2563eb; letter-spacing: 1px;">
        <i class="fa-solid fa-calendar-days"></i> EvenTeca
    </div>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <a href="{{ url('/home/user') }}" class="btn-primario" style="display: flex; align-items: center; gap: 0.5rem; font-weight: bold; color: #2563eb; background: none; border: none; font-size: 1.1rem; text-decoration: none; padding: 0; box-shadow: none;"><i class="fa-solid fa-house"></i> Início</a>
    </div>
    <div style="display: flex; align-items: center; gap: 2rem;">
        <div class="user-actions" style="display: flex; align-items: center; gap: 1.5rem;">
            <span style="font-weight: bold; color: #2563eb;"><i class="fa-solid fa-user"></i> {{ Auth::user()->name }}</span>
            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="color: #2563eb; font-weight: bold; text-decoration: none; margin-left: 0.5rem; transition: color 0.2s;"><i class="fa-solid fa-right-from-bracket"></i> Sair</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>
<div class="main-center" style="max-width: 700px; margin: 90px auto 0 auto; background: #fff; border-radius: 18px; box-shadow: 0 4px 24px #0002; padding: 2.5rem 2.5rem 2rem 2.5rem;">
    <h2 class="home-event-title" style="text-align:center; margin-bottom: 2rem;">{{ $event->title }}</h2>
    <div class="event-info" style="display: flex; flex-direction: column; gap: 0.7rem; font-size: 1.08rem; color: #334155; margin-bottom: 2rem;">
        <div><strong>Descrição:</strong> {{ $event->description }}</div>
        <div><strong>Categoria:</strong> {{ $event->category }}</div>
        <div><strong>Início:</strong> {{ $event->start_time->format('d/m/Y H:i') }}</div>
        @if($event->end_time)
            <div><strong>Fim:</strong> {{ $event->end_time->format('d/m/Y H:i') }}</div>
        @endif
        <div><strong>Local:</strong> {{ $event->location }}</div>
        <div><strong>Capacidade:</strong> {{ $event->capacity }}</div>
        <div><strong>Preço:</strong> <span style="color:#2563eb; font-weight:bold;">R$ {{ number_format($event->price, 2, ',', '.') }}</span></div>
    </div>
    <div style="display: flex; gap: 1rem; align-items: center; margin-bottom: 2rem;">
        @if(!$registration || (isset($registration) && $registration->status === 'cancelado'))
            <form method="POST" action="{{ route('registrations.subscribe', $event->id) }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-primary" style="background:#2563eb; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:bold; text-decoration:none;">Inscrever-se</button>
            </form>
        @elseif($registration->status === 'pendente')
            <script>window.location.href = '{{ route('registrations.payment', $event->id) }}';</script>
        @else
            <span class="badge bg-success ml-2" style="background:#22c55e; color:#fff; border-radius:8px; padding:10px 24px; font-weight:bold;">Inscrição confirmada</span>
            <form method="POST" action="{{ route('registrations.unsubscribe', $event->id) }}" style="display:inline; margin-left: 1rem;">
                @csrf
                <button type="submit" class="btn btn-danger" style="background:#dc2626; color:#fff; border:none; border-radius:8px; padding:10px 24px; font-weight:bold; text-decoration:none; margin-left: 0.5rem;">Cancelar inscrição</button>
            </form>
        @endif
    </div>
    <div style="text-align:center;">
        <a href="{{ url('/home') }}" class="btn btn-secondary" style="background:#e5e7eb; color:#2563eb; border-radius:8px; padding:10px 24px; font-weight:bold; text-decoration:none;">Voltar</a>
    </div>
</div>
@endsection
