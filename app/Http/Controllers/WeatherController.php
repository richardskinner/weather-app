<?php

namespace App\Http\Controllers;

use App\Modules\Weather\Repositories\WeatherRepositoryInterface;
use App\Serialisers\ForecastCollectionSerialiser;
use App\Services\CityServiceInterface;
use Illuminate\Http\JsonResponse;

class WeatherController extends Controller
{
    public function get(
        CityServiceInterface $cityService,
        WeatherRepositoryInterface $weatherRepository,
        ?string $city = null
    ): JsonResponse
    {
        if (empty($city)) {
            $cities = $cityService->getAllCities();
        } else {
            $cities = collect([$cityService->getCity($city)])->filter();
        }

        return response()->json([
            'status' => 'ok',
            'data' => ForecastCollectionSerialiser::toArray($cities),
        ]);
    }
}
