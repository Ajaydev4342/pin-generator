<?php

namespace AjayDev\PinGenerator;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class PinGeneratorServiceProvider extends ServiceProvider
{
    protected $defer = true;
 
    public function register()
    {
        $this->app->bind('pin-generator', function () {
            $cache = Cache::store();
            return new PinGenerator($cache);
        });
    }

    public function provides()
    {
        return ['pin-generator'];
    }
}





