<?php

namespace App\Providers;

use App\WeatherServices\OpenWeatherMap;
use App\WeatherServices\WeatherInterface;
use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
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
        $this->app->bind(WeatherInterface::class, function () {
            return new OpenWeatherMap();
        });
    }

    public function provides()
    {
        return [WeatherInterface::class];
    }
}
