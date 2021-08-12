<?php

namespace App\Providers;

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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Article' => 'App\Policies\ArticlePolicy',
        'App\Models\Permission' => 'App\Policies\PermissionPolicy',
        'App\Models\Menu' => 'App\Policies\MenuPolicy',
        'App\Models\User' => 'App\Policies\UserPolicy',
        'App\Models\Portfolio' => 'App\Policies\PortfolioPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('VIEW_ADMIN', function ($user) {
            return $user->canDo(['VIEW_ADMIN', 'ADD_ARTICLES'], true);
        });

        Gate::define('VIEW_ADMIN_ARTICLES', function ($user) {
            return $user->canDo('VIEW_ADMIN_ARTICLES', true);
        });

        Gate::define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', true);
        });

        Gate::define('VIEW_ADMIN_MENU', function ($user) {
            return $user->canDo('VIEW_ADMIN_MENU', true);
        });

        Gate::define('ADMIN_USERS', function ($user) {
            return $user->canDo('ADMIN_USERS', true);
        });

        Gate::define('EDIT_USERS', function ($user) {
            return $user->canDo('EDIT_USERS', true);
        });
        
        Gate::define('VIEW_ADMIN_PORTFOLIOS', function ($user) {
            return $user->canDo('VIEW_ADMIN_PORTFOLIOS', true);
        });

        Gate::define('EDIT_PORTFOLIOS', function ($user) {
            return $user->canDo('VIEW_ADMIN_PORTFOLIOS', true);
        });

        Gate::define('SAVE_PORTFOLIOS', function ($user) {
            return $user->canDo('VIEW_ADMIN_PORTFOLIOS', true);
        });

        // Gate::define('EDIT_MENU', function ($user) {
        //     return $user->canDo('EDIT_MENU', true);
        // });

    }
}
