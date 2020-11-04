<?php

namespace App\Providers;

use Dnetix\Redirection\PlacetoPay;
use Illuminate\Support\ServiceProvider;

class GatewaySeriveProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(PlacetoPay::class, function ($app) {
            return new PlacetoPay([
                'login' => env('PLACE_TO_PAY_LOGIN'),
                'tranKey' => env('PLACE_TO_TRAN_KEY'),
                'url' => env('PLACE_TO_TRAN_URL'),
            ]);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
