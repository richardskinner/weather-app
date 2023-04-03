<?php

namespace App\Serialisers;


use App\Modules\Weather\Repositories\WeatherRepositoryInterface;
use Illuminate\Support\Collection;

class ForecastCollectionSerialiser
{
    public function __construct(private WeatherRepositoryInterface $weatherRepository)
    {

    }

    public static function toArray(Collection $cities)
    {
        $self = (new self(app(WeatherRepositoryInterface::class)));

        return $cities->map(
            function ($city) use ($self) {
                $forecast = $self->weatherRepository->getWeatherForecast($city->city);
                return ForecastSerialiser::toArray($forecast);
            }
        );
    }
}