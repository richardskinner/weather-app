<?php

namespace App\Services;

use App\Models\City;
use App\Modules\Weather\Repositories\WeatherRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CityService implements CityServiceInterface
{
    public function __construct(private WeatherRepositoryInterface $weatherRepository)
    {

    }
    public function storeCity(string $city): City
    {
        Cache::forget(CacheCityService::ALL_CITIES_CACHE);
        $city = $this->weatherRepository->getCityData($city);
        return City::create([
            'city' => $city->getName(),
            'country' => $city->getCountry(),
            'country_iso' => $city->getCountryIso(),
            'longitude' => $city->getLongitude(),
            'latitude' => $city->getLatitude(),
        ]);
    }

    public function getAllCities(): Collection
    {
        return City::all();
    }

    public function getCity(?string $city): ?City
    {
        return City::where('city', $city)->first();
    }
}