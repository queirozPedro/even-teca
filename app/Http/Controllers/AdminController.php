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
        $events = Event::with('users')->get();
        return view('admin', compact('users', 'events'));
    }

    public function editUser($id)
    {
        $users = User::all();
        $editUser = User::findOrFail($id);
        $events = Event::with('users')->get();
        return view('admin', compact('users', 'editUser', 'events'));
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
        $users = User::all();
        $events = Event::with('users')->get();
        return view('admin', compact('users', 'events'));
    }
    public function reports()
    {
        $user = auth()->user();
        if ($user->role === 'admin') {
            $events = Event::withCount('users')->orderByDesc('users_count')->get();
        } else {
            $events = Event::where('organizer_id', $user->id)
                ->withCount('users')
                ->orderByDesc('users_count')
                ->get();
        }
        $users = User::all();
        return view('admin', compact('users', 'events'));
    }
}