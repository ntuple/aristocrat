<?php

namespace Matrix\Aristocrat;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider
{
    public function register()
    {
        $this->app['config']->package('matrix/aristocrat/', __DIR__.'/config');

        $this->app->bind('aristocrat', function ($app) {
            return new Aristocrat($this->app['config']->get('aristocrat::configs'));
        });
    }

    public function provides()
    {
        return ['aristocrat'];
    }
}
