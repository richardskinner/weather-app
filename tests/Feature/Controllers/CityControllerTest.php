<?php

namespace Tests\Feature\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\StubHttpWeatherClient;
use Tests\TestCase;

class CityControllerTest extends TestCase
{
    use StubHttpWeatherClient, RefreshDatabase;

    public function testStoreCityReturnsSuccessfulResponse(): void
    {
        $this->stubGeoHttpRequest();
        $response = $this->post(route('api.city.store'), ['city' => 'London']);
        $response->assertOk();
        $this->assertDatabaseHas('cities', ['city' => 'London', 'country' => 'England', 'country_iso' => 'GB', 'latitude' => 51.5073219, 'longitude' => -0.1276474]);
    }

    public function testStoreCityReturnsUnsuccessfulResponse(): void
    {
        $this->stubGeoHttpRequest(json_encode([]));
        $response = $this->post(route('api.city.store'), ['city' => 'London']);
        $response->assertBadRequest();
        $response->assertJson(['status' => 'error', 'message' => 'Data retrieval error', 'data' => ['city' => 'No data found with Open Weather Map.']]);
    }

    public function testValidationFails()
    {
        $response = $this->post(route('api.city.store'), [], ['Accept' => 'application/json']);
        $response->assertBadRequest();
        $response->assertJsonStructure(['status', 'message', 'data' => ['city' => []]]);
    }
}
