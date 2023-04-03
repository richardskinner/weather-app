<?php

namespace App\Serialisers;

use App\Modules\Weather\ValueObjects\Forecast;

class ForecastSerialiser
{
    public static function toArray(Forecast $forecast)
    {
        return [
            'city' => $forecast->getCityName(),
            'forecast' => $forecast->getForecast()
        ];
    }
}