<?php

namespace Tests\Feature\Modules\Weather;

use App\Modules\Weather\WeatherClient;
use Illuminate\Http\Client\Response;
use Tests\StubHttpWeatherClient;
use Tests\TestCase;

class WeatherClientTest extends TestCase
{
    use StubHttpWeatherClient;

    /**
     * A basic test example.
     */
    public function testGetWeatherReturnsSuccessfulResponse(): void
    {
        $this->stubForecastHttpRequest();

        $weatherClient = new WeatherClient();
        $response = $weatherClient->getWeather('London');

        $this->assertInstanceOf(Response::class, $response);
    }

    public function testGetCitySuccessfulResponse(): void
    {
        $this->stubGeoHttpRequest();

        $weatherClient = new WeatherClient();
        $response = $weatherClient->getCity('London');

        $this->assertInstanceOf(Response::class, $response);
    }
}
