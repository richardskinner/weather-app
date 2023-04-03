<?php

namespace App\Modules\Weather\Repositories;

use App\Modules\Weather\Exceptions\WeatherRepositoryException;
use App\Modules\Weather\ValueObjects\City;
use App\Modules\Weather\ValueObjects\Forecast;
use App\Modules\Weather\ValueObjects\Weather;
use App\Modules\Weather\WeatherClientInterface;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class WeatherRepository implements WeatherRepositoryInterface
{
    public function __construct(private WeatherClientInterface $client)
    {

    }

    public function getWeatherForecast(string $city): Forecast
    {
        $response = $this->client->getWeather($city);
        $cityData = Arr::get($response->json(), 'city');
        $forecastData = Arr::get($response->json(), 'list');
        $forecast = collect($forecastData)
            ->map(
                fn($weather) => new Weather(
                    $weather['dt'],
                    $weather['weather'][0]['main'],
                    $weather['weather'][0]['description']
                )
            );

        return new Forecast($cityData, $forecast->toArray());
    }

    public function getCityData(string $city): City
    {
        $response = $this->client->getCity($city);

        if (empty($data = $response->json('0'))) {
            throw new WeatherRepositoryException('No data found with Open Weather Map.');
        }

        return new City($data['name'], $data['state'], $data['country'], $data['lat'], $data['lon']);
    }
}