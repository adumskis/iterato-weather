<?php

namespace App\Facades;

use App\WeatherServices\WeatherInterface;
use Illuminate\Support\Facades\Facade;

/**
 * Weather facade
 * @package App\Facades
 * @method raw($city)
 * @method query($query)
 * @method units($units)
 */
class Weather extends Facade
{
    protected static function getFacadeAccessor()
    {
        return WeatherInterface::class;
    }
}