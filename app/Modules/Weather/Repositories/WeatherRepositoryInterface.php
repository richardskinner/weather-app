<?php

namespace App\Modules\Weather\Repositories;

use App\Modules\Weather\ValueObjects\City;
use App\Modules\Weather\ValueObjects\Forecast;

interface WeatherRepositoryInterface
{
    public function getWeatherForecast(string $city): Forecast;
    public function getCityData(string $city): City;
}