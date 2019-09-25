<?php

namespace Artisan\Aviator;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AviatorServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Route::group([
            'namespace' => 'Artisan\Aviator\Http\Controllers',
            'prefix' => 'aviator',
        ], function () {
            require __DIR__ . '/Http/routes.php';
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
