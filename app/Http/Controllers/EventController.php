<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests; 
use Illuminate\Http\Request;
use App\Models\Event;
use App\Notifications\RegistrationConfirmed;
use App\Notifications\RegistrationApproved;
use App\Notifications\RegistrationRejected;
use App\Notifications\EventReminder;

class EventController extends Controller
{
    use AuthorizesRequests; 

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
        return view('event.index', compact('events'));
    }

    /**
     * Mostra o formulário para criar um novo evento.
     */
    public function create()
    {
        $events = Event::all();
        $createEvent = true;
        return view('event.create');
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
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        $validated['organizer_id'] = auth()->id();
        $validated['price'] = $validated['price'] ?? 0;

        \App\Models\Event::create($validated);

        // Redireciona para a home do organizador
        return redirect()->route('home.organizer')->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Mostra o formulário para editar um evento.
     */
    public function edit(string $id)
    {
        $editEvent = \App\Models\Event::findOrFail($id);
        $this->authorize('update', $editEvent); // Adicione esta linha
        $events = \App\Models\Event::all();
        return view('event.edit', compact('events', 'editEvent'));
    }

    /**
     * Atualiza um evento no banco de dados.
     */
    public function update(Request $request, string $id)
    {
        $event = \App\Models\Event::findOrFail($id);
        $this->authorize('update', $event);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date|after_or_equal:start_time',
            'location' => 'nullable|string|max:255',
            'capacity' => 'nullable|integer|min:1',
            'price' => 'nullable|numeric|min:0',
        ]);

        $validated['price'] = $validated['price'] ?? 0;

        $event->update($validated);

        // Redireciona para a home do organizador
        return redirect()->route('home.organizer')->with('success', 'Evento atualizado com sucesso!');
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
        $user = auth()->user();
        if ($event->capacity !== null && $event->registrations()->count() >= $event->capacity) {
            return back()->with('error', 'Event is full!');
        }

        $registration = \App\Models\Registration::firstOrCreate([
            'user_id' => $user->id,
            'event_id' => $event->id,
        ], [
            'status' => 'pendente',
            'registered_at' => now(),
        ]);

        $user->notify(new \App\Notifications\RegistrationConfirmed($event));
        return back()->with('success', 'Inscrição realizada! Aguarde aprovação do organizador.');
    }

    /**
     * Cancela a inscrição do usuário em um evento.
     */
    public function unsubscribe(Event $event)
    {
        $user = auth()->user();
        \App\Models\Registration::where('user_id', $user->id)
            ->where('event_id', $event->id)
            ->delete();
        return back()->with('success', 'Inscrição cancelada com sucesso!');
    }

    /**
     * Exibe os participantes de um evento.
     */
    public function attendees(Event $event)
    {
        $attendees = $event->registrations()->with('user')->get();
        return view('partials.attendees_list', compact('attendees', 'event'));
    }

    /**
     * Aprova a inscrição de um usuário em um evento.
     */
    public function approveRegistration(Event $event, $userId)
    {
        $registration = \App\Models\Registration::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->firstOrFail();
        $registration->update(['status' => 'confirmado']);
        $user = \App\Models\User::find($userId);
        $user->notify(new \App\Notifications\RegistrationApproved($event));
        return back()->with('success', 'Inscrição aprovada!');
    }

    /**
     * Rejeita a inscrição de um usuário em um evento.
     */
    public function rejectRegistration(Event $event, $userId)
    {
        $registration = \App\Models\Registration::where('user_id', $userId)
            ->where('event_id', $event->id)
            ->firstOrFail();
        $registration->update(['status' => 'cancelado']);
        $user = \App\Models\User::find($userId);
        $user->notify(new \App\Notifications\RegistrationRejected($event));
        return back()->with('success', 'Inscrição rejeitada!');
    }

    /**
     * Envia lembretes para os participantes de eventos que começam no dia seguinte.
     */
    public function sendReminders()
    {
        foreach (\App\Models\Event::whereDate('start_time', now()->addDay())->get() as $event) {
            foreach ($event->registrations()->with('user')->get() as $registration) {
                $registration->user->notify(new \App\Notifications\EventReminder($event));
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
        return view('event.show', compact('events', 'showEvent'));
    }

    /**
     * Exibe o formulário para exclusão de um evento.
     */
    public function delete($id)
    {
        $eventToDelete = \App\Models\Event::findOrFail($id);
        $events = \App\Models\Event::all();
        return view('eventos', compact('events', 'eventToDelete'));
    }

    /**
     * Exibe as inscrições do usuário.
     */
    public function myRegistrations()
    {
        $user = auth()->user();
        $registrations = $user->registrations()->with('event')->get();
        return view('events.my_registrations', compact('registrations'));
    }
}
