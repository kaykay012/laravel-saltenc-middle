<?php

namespace kaykay012\laravelsaltenc;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider
{

    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        $this->addMiddlewareAlias('saltenc.api', saltEnc::class);
    }

    protected function addMiddlewareAlias($name, $class)
    {
        $router = $this->app['router'];

        if (method_exists($router, 'aliasMiddleware')) {
            return $router->aliasMiddleware($name, $class);
        }

        return $router->middleware($name, $class);
    }

}
