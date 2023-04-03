<?php

namespace App\Modules\Weather;

use Illuminate\Http\Client\Response;

interface WeatherClientInterface
{
    public function getWeather(string $city): Response;
    public function getCity(string $city): Response;
}