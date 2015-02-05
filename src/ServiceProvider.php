<?php namespace Matrix\Aristocrat;

use Illuminate\Support\ServiceProvider as IlluminateServiceProvider;

class ServiceProvider extends IlluminateServiceProvider {

    function register()
    {
        \Log::debug("AristocratServiceProvider registered");
        $this->app['config']->package('aristocrat/', __DIR__ . '/config');
        $this->app->bind('aristocrat', function ($app) {
            return new Aristocrat($this->app['config']);
        });
    }

    public function provides()
    {
        return array('aristocrat');
    }

}