<?php

namespace App\Modules\Weather;

use Illuminate\Support\Arr;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class WeatherClient implements WeatherClientInterface
{
    private mixed $options;

    public function __construct()
    {
        $this->options = config('weather');
    }

    public function getWeather(string $city): Response
    {
        $url = Arr::get($this->options, 'source.forecast');

        return $this->sendRequest($url, [$city]);
    }

    public function getCity(string $city): Response
    {
        $url = Arr::get($this->options, 'source.geo');

        return $this->sendRequest($url, [$city]);
    }

    private function sendRequest(string $url, array $params): Response
    {
        $key = $this->options['key'];

        return Http::get(sprintf($url, $key, ...$params));
    }
}