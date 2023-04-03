# Weather App
This weathe app has been built using the Laravel framework and Open Weather Maps API.

### Requirements
* Docker
* Docker Compose
* Composer

### Setup
To set up the project, run `docker-compose up -d --build --force-recreate` from the root directory.

Log into the container `docker exec -it weather-app_php_1 bash`

Then run:
```bash
composer install
php artisan migrate
```

## Application

### Artisan
To execute the artisan command, run `php artisan weather:fetch`.

You can also fetch a single cities weather forecast `php artisan weather:fetch --city=London`

### API
To add a city:
```curl
curl -X POST http://localhost:8080/api/city -H "Content-Type: application/json" -d '{"city": "London"}'
```

To get weather for a cities:
```curl
curl -X GET http://localhost:8080/api/weather -H "Content-Type: application/json"
```

To get weather for a single city:
```curl
curl -X GET http://localhost:8080/api/weather/london -H "Content-Type: application/json"
```

## Testing
To run tests `./vendor/bin/phpunit`

I could have had better test coverage but for the purpose of this tech test, I think what has been done demonstrates how 
I approach tests and write them.

## Implementation Details
This was built on Laravel 10, using docker as the dev server.

## Comments
Although the API endpoints and artisan command works as expected, I was a little confused with the instructions. 
I wasn't sure if the data from the OpenWeatherMaps API should be saved or just the cities, therefore if a city hasn't 
been stored in the database the response will return as an empty array. 

While I am happy with the test, I do believe the testing coverage isn't good enough and some decisions around 
architecture may have been overkill for what needed to be achieved in this test e.g. Serialiser, Value Objects.

I have tried to use Interfaces where I thought implementations maybe replaced in teh future for example: If we wanted
to use another source for the weather.