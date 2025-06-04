<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Support\Facades\Gate;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageEvents(\App\Models\User $user, $event = null)
    {
        return $user->isAdmin() || $user->isOrganizer();
    }
    
    public function update(\App\Models\User $user, \App\Models\Event $event)
    {
        // Só o organizer que criou pode editar
        return $user->role === 'organizer' && $event->organizer_id === $user->id;
    }
}
