<?php

namespace App\Facades;

use App\WeatherServices\WeatherInterface;
use Illuminate\Support\Facades\Facade;

class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {
        return WeatherInterface::class;
    }
}