<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isOrganizer()) {
            $events = \App\Models\Event::where('organizer_id', $user->id)->get();
            return view('home.organizer', [
                'events' => $events,
                'isOrganizer' => true,
            ]);
        }

        if ($user->isUser()) {
            $registrations = $user->registrations()->with('event')->get();
            $inscritosIds = $registrations->pluck('event_id')->toArray();
            $eventsDisponiveis = \App\Models\Event::whereNotIn('id', $inscritosIds)->get();

            return view('home.user', [
                'eventsDisponiveis' => $eventsDisponiveis,
                'registrations' => $registrations,
            ]);
        }

        // fallback
        return view('home.organizer');
    }
    
    public function myRegistrations()
    {
        $user = auth()->user();
        $registrations = $user->registrations()->with('event')->get();
        return view('my_registrations', compact('registrations'));
    }
    
    public function editProfile()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }
        $user->save();

        return redirect('/home')->with('success', 'Perfil atualizado com sucesso!');
    }
}
