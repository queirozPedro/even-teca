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
}
