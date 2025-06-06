<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Policies\EventPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        \App\Models\Event::class => \App\Policies\EventPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        \Illuminate\Support\Facades\Gate::define('manage-events', [\App\Policies\EventPolicy::class, 'manageEvents']);
    }
}