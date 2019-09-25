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
        $this->registerRoutes();
    }

    protected function registerRoutes()
    {
        Route::group([
            'namespace' => 'Artisan\Aviator\Http\Controllers',
            'prefix' => 'aviator',
        ], function () {
            $this->loadViews();
        });
    }

    protected function loadViews()
    {
        require __DIR__ . '/Http/routes.php';
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
