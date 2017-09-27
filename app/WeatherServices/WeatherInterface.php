<?php

namespace App\WeatherServices;

interface WeatherInterface
{
    public function raw($city);

    public function query($query);

    public function units($units);
}