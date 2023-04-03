<?php

namespace App\Providers;

use App\Modules\Weather\Repositories\WeatherRepository;
use App\Modules\Weather\Repositories\WeatherRepositoryInterface;
use App\Modules\Weather\WeatherClient;
use App\Modules\Weather\WeatherClientInterface;
use App\Services\CacheCityService;
use App\Services\CityService;
use App\Services\CityServiceInterface;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(WeatherClientInterface::class, function () {
            return new WeatherClient();
        });
        $this->app->bind(WeatherRepositoryInterface::class, function (Application $app) {
            return new WeatherRepository($app->get(WeatherClientInterface::class));
        });
        $this->app->bind(CityServiceInterface::class, function (Application $app) {
            return new CacheCityService(
                new CityService($app->get(WeatherRepositoryInterface::class))
            );
        });
    }
}
