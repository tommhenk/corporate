<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/admin';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        Route::pattern('alias', '[\w-]+');

        Route::bind('alias', function ($value) {
            // dd($value);
            
            return !empty(\App\Models\Article::where('alias', $value)->first()) ? \App\Models\Article::where('alias', $value)->first() : $value;
        });

        Route::bind('menu', function ($value) {
            // dd(\App\Models\Menu::where('id', $value)->first());
            return \App\Models\Menu::where('id', $value)->first();
        });

        Route::bind('user', function ($value) {
            // dd(\App\Models\Menu::where('id', $value)->first());
            return \App\Models\User::where('id', $value)->first();
        });

        Route::bind('portfolio', function ($value) {
            // dd(\App\Models\Menu::where('id', $value)->first());
            return \App\Models\Portfolio::where('id', $value)->first();
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
