<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Notifications\RegistrationConfirmed;
use App\Notifications\RegistrationApproved;
use App\Notifications\RegistrationRejected;
use App\Notifications\EventReminder;

class EventController extends Controller
{
    /**
     * Exibe a lista de eventos.
     */
    public function index(Request $request)
    {
        $query = Event::query();
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }
        if ($request->filled('location')) {
            $query->where('location', 'like', '%'.$request->location.'%');
        }
        if ($request->filled('start_time')) {
            $query->whereDate('start_time', '>=', $request->start_time);
        }
        $events = $query->get();
        return view('eventos', compact('events'));
    }

    /**
     * Mostra o formulário para criar um novo evento.
     */
    public function create()
    {
        $events = Event::all();
        $createEvent = true;
        return view('eventos', compact('events', 'createEvent'));
    }

    /**
     * Salva um novo evento no banco de dados.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'category' => 'nullable|string|max:255',
        ]);

        $validated['organizer_id'] = auth()->id();

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um evento.
     */
    public function edit(string $id)
    {
        $editEvent = Event::findOrFail($id);
        $events = Event::all();
        return view('eventos', compact('events', 'editEvent'));
    }

    /**
     * Atualiza um evento no banco de dados.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer',
            'price' => 'nullable|numeric',
            'category' => 'nullable|string|max:255',
        ]);

        $event = Event::findOrFail($id);
        $event->update($validated);

        return redirect()->route('events.index')->with('success', 'Evento atualizado com sucesso!');
    }

    /**
     * Remove um evento do banco de dados.
     */
    public function destroy(string $id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.index')->with('success', 'Evento excluído com sucesso!');
    }

    /**
     * Inscreve o usuário em um evento.
     */
    public function subscribe(Event $event)
    {
        if ($event->capacity !== null && $event->users()->count() >= $event->capacity) {
            return back()->with('error', 'Event is full!');
        }
        $user = auth()->user();
        $event->users()->syncWithoutDetaching([
            $user->id => ['status' => 'pending']
        ]);
        $user->notify(new RegistrationConfirmed($event));
        return back()->with('success', 'Inscrição realizada! Aguarde aprovação do organizador.');
    }

    /**
     * Cancela a inscrição do usuário em um evento.
     */
    public function unsubscribe(Event $event)
    {
        $user = auth()->user();
        $event->users()->detach($user->id);
        return back()->with('success', 'Inscrição cancelada com sucesso!');
    }

    /**
     * Exibe os participantes de um evento.
     */
    public function attendees(Event $event)
    {
        $this->authorize('manage-events');
        $attendees = $event->users()->withPivot('status')->get();
        $attendeesEvent = $event;
        $events = Event::all();
        return view('eventos', compact('events', 'attendees', 'attendeesEvent'));
    }

    /**
     * Aprova a inscrição de um usuário em um evento.
     */
    public function approveRegistration(Event $event, $userId)
    {
        $this->authorize('manage-events');
        $event->users()->updateExistingPivot($userId, ['status' => 'confirmed']);
        $user = \App\Models\User::find($userId);
        $user->notify(new RegistrationApproved($event));
        return back()->with('success', 'Inscrição aprovada!');
    }

    /**
     * Rejeita a inscrição de um usuário em um evento.
     */
    public function rejectRegistration(Event $event, $userId)
    {
        $this->authorize('manage-events');
        $event->users()->updateExistingPivot($userId, ['status' => 'rejected']);
        $user = \App\Models\User::find($userId);
        $user->notify(new RegistrationRejected($event));
        return back()->with('success', 'Inscrição rejeitada!');
    }

    /**
     * Envia lembretes para os participantes de eventos que começam no dia seguinte.
     */
    public function sendReminders()
    {
        foreach (Event::whereDate('start_time', now()->addDay())->get() as $event) {
            foreach ($event->users as $user) {
                $user->notify(new EventReminder($event));
            }
        }
    }

    /**
     * Exibe os detalhes de um evento específico.
     */
    public function show(string $id)
    {
        $showEvent = \App\Models\Event::findOrFail($id);
        $events = \App\Models\Event::all();
        return view('eventos', compact('events', 'showEvent'));
    }
}
