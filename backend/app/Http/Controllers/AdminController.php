<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function users()
    {
        $users = User::all();
        $events = Event::with('registrations.user')->get();
        return view('admin.index', compact('users', 'events'));
    }

    public function editUser($id)
    {
        $users = User::all();
        $editUser = User::findOrFail($id);
        $events = Event::with('registrations.user')->get();
        return view('admin.index', compact('users', 'editUser', 'events'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:user,organizer,admin',
        ]);
        $user->update($validated);
        return redirect()->route('admin.users')->with('success', 'Usuário atualizado!');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'Usuário excluído!');
    }

    public function events()
    {
        $users = User::all();
        $events = Event::with('registrations.user')->get();
        return view('admin.index', compact('users', 'events'));
    }
    public function reports()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $events = \App\Models\Event::withCount('registrations')->orderByDesc('registrations_count')->get();
        } else {
            $events = \App\Models\Event::where('organizer_id', $user->id)
                ->withCount('registrations')
                ->orderByDesc('registrations_count')
                ->get();
        }
        $users = \App\Models\User::all();
        return view('admin.index', compact('users', 'events'));
    }
}