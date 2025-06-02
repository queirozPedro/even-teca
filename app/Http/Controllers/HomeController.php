<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $events = \App\Models\Event::all();
        return view('home', compact('events'));
    }
    
    public function myRegistrations()
    {
        $user = auth()->user();
        $events = $user->events()->withPivot('status')->get();
        return view('my_registrations', compact('events'));
    }
    
    public function editProfile()
    {
        $user = auth()->user();
        return view('edit_profile', compact('user'));
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
