<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        City::create([
            'city' => 'London',
            'country' => 'England',
            'country_iso' => 'GB',
            'latitude' => 51.5073219,
            'longitude' => -0.1276474,
        ]);
    }
}
