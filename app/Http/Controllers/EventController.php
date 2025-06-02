<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class EventController extends Controller
{
    /**
     * Exibe a lista de eventos.
     */
    public function index()
    {
        $events = Event::all();
        return view('events.index', compact('events'));
    }

    /**
     * Mostra o formulário para criar um novo evento.
     */
    public function create()
    {
        return view('events.create');
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
        ]);

        Event::create($validated);

        return redirect()->route('events.index')->with('success', 'Evento criado com sucesso!');
    }

    /**
     * Exibe um evento específico.
     */
    public function show(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.show', compact('event'));
    }

    /**
     * Mostra o formulário para editar um evento.
     */
    public function edit(string $id)
    {
        $event = Event::findOrFail($id);
        return view('events.edit', compact('event'));
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
        $user = auth()->user();
        $event->users()->syncWithoutDetaching($user->id);
        return back()->with('success', 'Inscrição realizada com sucesso!');
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
}
