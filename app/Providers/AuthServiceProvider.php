<?php

namespace App\Providers;

use App\Role;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $super = '';
        $admin = "";
        $author ="";
        $user ="";

        $roles = Role::all();

        foreach ($roles as $role) {
             if($role->name == "Super"){
               $super = $role->id;
            }else if($role->name == "Admin"){
               $admin = $role->id;
            }else if($role->name == "Admin"){
               $author = $role->id;
            }else if($role->name == "Admin"){
               $user = $role->id;
            }
        }


        Gate::define('isSuperAdmin', function ($user) {
            return $user->role_id === 1;
        });

        Gate::define('isAdmin', function ($user) {
            return $user->role_id === 2;
        });

        Gate::define('isAuthor', function ($user) {
            return $user->role_id === 3;
        });

        Gate::define('isUser', function ($user) {
            return $user->role_id === 4;
        });

        Passport::routes();
    }
}
