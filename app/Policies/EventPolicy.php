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

    public function manageEvents(User $user)
    {
        return $user->isAdmin() || $user->isOrganizer();
    }
}

Gate::define('manage-events', [\App\Policies\EventPolicy::class, 'manageEvents']);
