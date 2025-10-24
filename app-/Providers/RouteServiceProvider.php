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
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(60)->by($request->user()->id ?: $request->ip());
        // });
        
        
        RateLimiter::for('api', function ($request) {
        return $request->user()
            ? Limit::perMinute(10000)->by($request->user()->id)  // Authenticated users: 200 requests/min
            : Limit::perMinute(500)->by($request->ip());       // Guests: 60 requests/min
    });
        
        
        
        
        
        
    //     RateLimiter::for('api', function ($request) {
    //     return Limit::perMinute(100)->by(optional($request->user())->id ?: $request->ip());
    // });
    
        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));

                   // Admin Route file 
            Route::middleware('web')
            ->group(base_path('routes/admin.php'));

             // Vendor Route file 
             Route::middleware('web')
             ->group(base_path('routes/vendor.php'));
                });
    }
}
