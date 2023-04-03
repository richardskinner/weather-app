<?php

namespace Tests\Unit;

use App\Modules\Weather\Exceptions\WeatherRepositoryException;
use App\Modules\Weather\Repositories\WeatherRepository;
use App\Modules\Weather\ValueObjects\City;
use App\Modules\Weather\ValueObjects\Forecast;
use App\Modules\Weather\WeatherClientInterface;
use Illuminate\Support\Collection;
use Illuminate\Http\Client\Response;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\MessageInterface;

class WeatherRepositoryTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function testRepositoryGetWeatherReturnsCollection(): void
    {
        $repository = new WeatherRepository($this->stubClient());
        $data = $repository->getWeatherForecast('London');

        $this->assertInstanceOf(Forecast::class, $data);
    }

    public function testGetCityDataReturnsCityModel(): void
    {
        $repository = new WeatherRepository($this->stubClient());
        $data = $repository->getCityData('London');

        $this->assertInstanceOf(City::class, $data);
    }

    public function testGetCityDataThrowsAnExceptionWhenNoDataReturned(): void
    {
        $this->expectException(WeatherRepositoryException::class);

        $clientMock  = $this->createMock(WeatherClientInterface::class);
        $clientMock->method('getCity')->willReturn(new Response($this->mockMessageInterface(json_encode([]))));

        $repository = new WeatherRepository($clientMock);
        $repository->getCityData('London');
    }

    private function stubClient():WeatherClientInterface
    {
        $clientMock  = $this->createMock(WeatherClientInterface::class);
        $clientMock->method('getWeather')
            ->willReturn(
                new Response($this->mockMessageInterface(file_get_contents(__DIR__ . '/../data/weather.json')))
            );
        $clientMock->method('getCity')
            ->willReturn(
                new Response($this->mockMessageInterface(file_get_contents(__DIR__ . '/../data/city.json')))
            );

        return $clientMock;
    }

    private function mockMessageInterface(string $body): MessageInterface
    {
        $mock = $this->createMock(MessageInterface::class);
        $mock->method('getBody')->willReturn($body);

        return $mock;
    }
}
