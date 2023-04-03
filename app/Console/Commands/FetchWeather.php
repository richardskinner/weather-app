<?php

namespace App\Console\Commands;

use App\Modules\Weather\Repositories\WeatherRepositoryInterface;
use App\Serialisers\ForecastCollectionSerialiser;
use App\Serialisers\ForecastSerialiser;
use App\Services\CityServiceInterface;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

class FetchWeather extends Command
{
    protected $signature = 'weather:fetch {--city=}';

    protected $description = 'Fetch Weather data';

    #[NoReturn] public function handle(CityServiceInterface $cityService): void
    {
        $city = $this->option('city');

        if (empty($city)) {
            $cities = $cityService->getAllCities();
        } else {
            $cities = collect([$cityService->getCity($city)])->filter();
        }

        $this->output->write(
            ForecastCollectionSerialiser::toArray($cities)->toJson(JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}
