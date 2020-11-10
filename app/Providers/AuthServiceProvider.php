<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.d
     */
    public function boot()
    {
        $this->registerPolicies();
        

        
        Gate::define('isSuperAdmin', function ($user) {
            return $user->role->name === 'Super';
        });

        Gate::define('isAdmin', function ($user) {
            return $user->role->name === 'Admin';
        });

        Gate::define('isUser', function ($user) {
            return $user->role->name === 'User';
        });
        
        Gate::define('isAuthor', function ($user) {
            return $user->role->name === 'Author';
        });

        // Gate::define('isSuperAdmin', function ($user) {
        //     return $user->role_id === 1;
        // });
        
        // Gate::define('isSuperAdmin', function ($user) {
        //     return $user->role_id === 1;
        // });

        // Gate::define('isAdmin', function ($user) {
        //     return $user->role_id === 2;
        // });

        // Gate::define('isUser', function ($user) {
        //     return $user->role_id === 3;
        // });


        Passport::routes();

        // Passport::loadKeysFrom('/secret-keys/oauth');
        
        // Passport::tokensExpireIn(now()->addDays(15));

        // Passport::refreshTokensExpireIn(now()->addDays(30));

        // Passport::personalAccessTokensExpireIn(now()->addMonths(6));
    }
}
