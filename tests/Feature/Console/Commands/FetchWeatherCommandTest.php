<?php

namespace Tests\Feature\Console\Commands;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Database\Seeders\CitySeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\StubHttpWeatherClient;
use Tests\TestCase;

class FetchWeatherCommandTest extends TestCase
{
    use StubHttpWeatherClient, RefreshDatabase, DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();
        $this->seed(CitySeeder::class);
    }

    public function testApplicationReturnsSuccessfulResponse(): void
    {
        $this->stubForecastHttpRequest();
        $this->artisan('weather:fetch')->assertOk();
    }
}
