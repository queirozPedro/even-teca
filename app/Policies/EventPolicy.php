<?php

namespace App\Policies;

use App\Models\User;

class EventPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function manageEvents(User $user)
    {
        return $user->isAdmin() || $user->isOrganizer();
    }
}
