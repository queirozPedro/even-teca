<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Event;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    // Histórico de pagamentos do usuário
    public function userHistory()
    {
        $user = Auth::user();
        $payments = Payment::whereHas('registration', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['registration.event'])->get();
        $total = $payments->sum('amount');
        return view('payment.payment_user', compact('payments', 'total'));
    }

    // Histórico de ganhos do organizador
    public function organizerHistory()
    {
        $user = Auth::user();
        $events = Event::where('organizer_id', $user->id)->with(['registrations.payment'])->get();
        $total = 0;
        foreach ($events as $event) {
            foreach ($event->registrations as $registration) {
                if ($registration->payment) {
                    $total += $registration->payment->amount;
                }
            }
        }
        return view('payment.payment_organizer', compact('events', 'total'));
    }
}
