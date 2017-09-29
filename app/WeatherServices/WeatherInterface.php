<?php

namespace App\WeatherServices;

/**
 * Interface WeatherInterface
 * @package App\WeatherServices
 */
interface WeatherInterface
{
    /**
     * Get raw response from weather provider
     * @param string|null $city
     * @return mixed
     */
    public function raw($city);

    /**
     * Query string to find needed city
     * @param string $query
     * @return mixed
     */
    public function query($query);

    /**
     * Set units type
     * @param string $units
     * @return mixed
     */
    public function units($units);
}