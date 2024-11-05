<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route; 
use Illuminate\Support\Facades\RateLimiter; 
use Illuminate\Http\Request; 
use Illuminate\Cache\RateLimiter as Limit;

class RouteServiceProvider extends ServiceProvider
{
    protected $namespace = 'App\Http\Controllers';

    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->routes();
    }

    protected function routes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

}
