<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\Adminpolicy;
use App\Policies\Rolepolicy;
use App\Policies\Userpolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // User::class=>Rolepolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('is-admin',function($user){
            return $user->hasAnyRoles(['The Ceo','General Manager']);
        });


        // Gate::define('manageRoles',[Rolepolicy::class,'manageRoles']);
        // Gate::define('accessUsers',[Userpolicy::class,'accessUsers']);
        // Gate::define('manageUsers',[Userpolicy::class,'manageUsers']);
        // Gate::define('accessAdmins',[Adminpolicy::class,'accessAdmins']);
        // Gate::define('manageAdmins',[Adminpolicy::class,'manageAdmins']);
    }
}
