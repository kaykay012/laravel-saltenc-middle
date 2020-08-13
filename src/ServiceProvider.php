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
        $this->app[\Illuminate\Contracts\Http\Kernel::class]->pushMiddleware(saltEnc::class);
    }

}
