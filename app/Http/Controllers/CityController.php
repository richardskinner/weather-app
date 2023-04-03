<?php

namespace App\Http\Controllers;

use App\Http\Enums\HttpStatusCodes;
use App\Http\Requests\CityRequest;
use App\Http\Resources\CityResource;
use App\Modules\Weather\Exceptions\WeatherRepositoryException;
use App\Services\CityService;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class CityController extends Controller
{
    public function store(CityRequest $request, CityService $cityService): JsonResponse
    {
        try {
            $city = $cityService->storeCity($request->get('city'));
        } catch (WeatherRepositoryException $e) {
            throw new HttpResponseException(response()->json([
                'status' => 'error',
                'message' => 'Data retrieval error',
                'data' => ['city' => $e->getMessage()],
            ], HttpStatusCodes::STATUS_BAD_REQUEST->value));
        }

        return response()->json([
            'status' => 'ok',
            'data' => new CityResource($city),
        ]);
    }
}
