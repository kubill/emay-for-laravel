<?php

namespace Kubill\Emay;

use Illuminate\Support\ServiceProvider;

class EmayServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('emay', function ($app) {
            return new Emay();
        });
    }
}
