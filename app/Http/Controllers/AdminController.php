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
        return view('admin.users', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
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
        $events = Event::with('users')->get();
        return view('admin.events', compact('events'));
    }
    public function reports()
    {
        // Para admin: todos os eventos; para organizer: só os dele
        $user = auth()->user();
        if ($user->role === 'admin') {
            $events = \App\Models\Event::withCount('users')->orderByDesc('users_count')->get();
        } else {
            $events = \App\Models\Event::where('organizer_id', $user->id)
                ->withCount('users')
                ->orderByDesc('users_count')
                ->get();
        }

        return view('admin.reports', compact('events'));
    }
}