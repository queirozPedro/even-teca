<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function boot()
    {
        $this->registerPolicies();

        // Gate para admin
        Gate::define('is-admin', function ($user) {
            return $user->role === 'admin';
        });

        // Gate para gerenciar eventos (já usada nas rotas)
        Gate::define('manage-events', [\App\Policies\EventPolicy::class, 'manageEvents']);
    }
}