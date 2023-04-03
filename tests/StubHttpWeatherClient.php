<?php

namespace Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

trait StubHttpWeatherClient
{
    protected function stubForecastHttpRequest(): void
    {
        $options = config('weather');
        $source = Arr::get($options, 'source.forecast');
        $key = $options['key'];
        $url = sprintf($source, $key, 'London');
        $fakeResponse = Http::response(file_get_contents(__DIR__ . '/data/weather.json'));

        Http::preventStrayRequests();
        Http::fake([$url => $fakeResponse]);
    }

    protected function stubGeoHttpRequest(string $response = null): void
    {
        $response ??= file_get_contents(__DIR__ . '/data/city.json');

        $options = config('weather');
        $source = Arr::get($options, 'source.geo');
        $key = $options['key'];
        $url = sprintf($source, $key, 'London');
        $fakeResponse = Http::response($response);

        Http::preventStrayRequests();
        Http::fake([$url => $fakeResponse]);
    }
}