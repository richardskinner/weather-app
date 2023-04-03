<?php

namespace App\Services;

use App\Models\City;
use Illuminate\Support\Collection;

interface CityServiceInterface
{
    public function getAllCities(): Collection;
    public function getCity(?string $city): ?City;
}