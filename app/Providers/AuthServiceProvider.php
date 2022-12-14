<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function($user) {
            return $user->role->name == 'Admin';
        });

        Gate::define('owner', function($user) {
            return $user->role->name == 'Owner';
        });

        Gate::define('staff', function($user) {
            return $user->role->name == 'Staff';
        });

        Gate::define('adminAndStaff', function($user){
            return $user->role->name == 'Admin' || $user->role->name == 'Staff';
        });
    }
}
