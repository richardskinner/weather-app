<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CacheCityService implements CityServiceInterface
{
    public const ALL_CITIES_CACHE = 'all_cities';

    public function __construct(private CityService $cityService)
    {
    }

    public function getAllCities(): Collection
    {
        return Cache::remember(
            self::ALL_CITIES_CACHE,
            3600,
            fn() => $this->cityService->getAllCities()
        );
    }

    public function getCity(?string $city): ?City
    {
        return Cache::rememberForever(strtolower($city), fn() => $this->cityService->getCity($city));
    }
}