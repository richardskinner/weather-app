<?php

return [
    'key' => env('OPEN_WEATHER_MAPS_API_KEY'),
    'source' => [
        'forecast' => 'api.openweathermap.org/data/2.5/forecast?appid=%s&q=%s',
        'geo' => 'api.openweathermap.org/geo/1.0/direct?appid=%s&q=%s',
    ]
];
