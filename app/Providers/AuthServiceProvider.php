<?php

namespace App\Providers;

use App\Models\Roles;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
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

        // $this->app['auth']->viaRequest('api', function ($request) {
        //     return app('auth')->setRequest($request)->user();
        // });

        // Gate Definition
        // Gate::define('admin', function ($user) {
        //     return $user->role_id == Roles::IS_ADMIN;
        // });
        // Gate::define('pelamar', function ($user) {
        //     return $user->role_id == Roles::IS_PELAMAR;
        // });
    }
}
