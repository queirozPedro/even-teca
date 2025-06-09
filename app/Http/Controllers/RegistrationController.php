<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    // Exibe detalhes do evento e status de inscrição
    public function show($eventId)
    {
        $event = Event::findOrFail($eventId);
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)->where('event_id', $event->id)->first();
        return view('registrations/show', compact('event', 'registration'));
    }

    // Inscreve o usuário no evento
    public function subscribe($eventId)
    {
        $user = Auth::user();
        $event = Event::findOrFail($eventId);
        $registration = Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->first();

        if ($registration && $registration->status === 'canceled') {
            $registration->status = 'pending';
            $registration->save();
        } elseif (!$registration) {
            $registration = Registration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'status' => 'pending',
            ]);
        }
        return redirect()->route('registrations.show', $event->id);
    }

    // Cancela a inscrição do usuário
    public function unsubscribe($eventId)
    {
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)->where('event_id', $eventId)->first();
        if ($registration) {
            $registration->status = 'canceled';
            $registration->save();
        }
        return redirect()->route('my.registrations');
    }

    // Exibe tela de pagamento fictício
    public function payment($eventId)
    {
        $event = Event::findOrFail($eventId);
        return view('registrations/payment_registration', compact('event'));
    }

    // Processa pagamento fictício
    public function pay(Request $request, $eventId)
    {
        $user = Auth::user();
        $registration = Registration::where('user_id', $user->id)->where('event_id', $eventId)->firstOrFail();
        $registration->status = 'confirmado';
        $registration->save();
        Payment::create([
            'registration_id' => $registration->id,
            'amount' => $request->input('amount', 0),
            'status' => 'completed',
            'payment_method' => $request->input('payment_method', 'credit_card'),
        ]);
        return redirect('/home')->with('success', 'Pagamento realizado com sucesso!');
    }
}
