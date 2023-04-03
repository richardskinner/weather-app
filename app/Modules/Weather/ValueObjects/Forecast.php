<?php

namespace App\Modules\Weather\ValueObjects;

use Illuminate\Contracts\Support\Arrayable;

class Forecast
{
    public function __construct(
        private array $city,
        private array $forecast = []
    )
    {

    }

    public function getCityName(): string
    {
        return $this->city['name'];
    }

    public function getForecast(): array
    {
        return $this->forecast;
    }
}