<?php

namespace AjayDev\PinGenerator;

use Illuminate\Support\Facades\Facade;

class PinGeneratorFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PinGenerator::class;
    } 
}