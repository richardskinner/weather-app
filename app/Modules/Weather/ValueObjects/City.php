<?php

namespace App\Modules\Weather\ValueObjects;

class City
{
    public function __construct(
        private string $name,
        private string $country,
        private string $countryIso,
        private float $latitude,
        private float $longitude
    )
    {

    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getLatitude(): float
    {
        return $this->latitude;
    }

    public function getLongitude(): float
    {
        return $this->longitude;
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCountryIso(): string
    {
        return $this->countryIso;
    }
}