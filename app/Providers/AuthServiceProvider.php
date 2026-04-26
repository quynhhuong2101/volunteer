<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        \Illuminate\Support\Facades\Gate::define('access-admin', function ($user) {
            return $user->role === \App\Enums\UserRole::ADMIN;
        });

        \Illuminate\Support\Facades\Gate::define('access-organization', function ($user) {
            return $user->role === \App\Enums\UserRole::ORGANIZER;
        });

        \Illuminate\Support\Facades\Gate::define('access-student', function ($user) {
            return $user->role === \App\Enums\UserRole::STUDENT;
        });
    }
}
