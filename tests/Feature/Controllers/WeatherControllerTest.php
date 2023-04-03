<?php

namespace Tests\Feature\Controllers;

use App\Models\City;
use App\Modules\Weather\WeatherClientInterface;
use App\Services\CacheCityService;
use App\Services\CityServiceInterface;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Client\Response;
use Psr\Http\Message\MessageInterface;
use Tests\StubHttpWeatherClient;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    use StubHttpWeatherClient, RefreshDatabase, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CitySeeder::class);
    }

    /**
     * A basic test example.
     */
    public function testApplicationReturnsSuccessfulResponse(): void
    {
        $cityServiceMock = $this->createMock(CacheCityService::class);
        $cityServiceMock->method('getAllCities')
            ->willReturn(collect([
                new City(['city' => "London"]),
                new City(['city' => "Birmingham"]),
                new City(['city' => "Manchester"]),
                new City(['city' => "Newcastle"]),
            ]));
        $weatherRepo = $this->mock(WeatherClientInterface::class);
        $weatherRepo->shouldReceive('getWeather')
            ->andReturn(
                $this->createResponse(file_get_contents(__DIR__ . '/../../data/forecasts/london.json')),
                $this->createResponse(file_get_contents(__DIR__ . '/../../data/forecasts/birmingham.json')),
                $this->createResponse(file_get_contents(__DIR__ . '/../../data/forecasts/manchester.json')),
                $this->createResponse(file_get_contents(__DIR__ . '/../../data/forecasts/newcastle.json')),
            );

        $this->app->bind(CityServiceInterface::class, fn() => $cityServiceMock);
        $this->app->bind(WeatherClientInterface::class, fn() => $weatherRepo);

        $response = $this->get(route('api.weather.get'));

        $response->assertJsonIsObject();
        $response->assertJsonStructure(['status', 'data' => [['city',  'forecast' => [['dateTime', 'title', 'description']]]]]);
        $this->assertCount(4, $response->json('data'));
    }

    private function createResponse(string $body): Response
    {
        $mockMessageInterface = $this->createMock(MessageInterface::class);
        $mockMessageInterface->method('getBody')->willReturn($body);

        return new Response($mockMessageInterface);
    }
}
