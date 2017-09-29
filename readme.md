# Weather readme
## How to start project
1. `$ git clone git@github.com:adumskis/weather.git`;
2. `$ cd weather`;
3. `$ cp .env.example .env`;
4. `$ composer install`;
5. `$ php artisan key:generate`;
6. Create database and set credentials in .env;
7. `$ php artisan migrate`;
8. Set right permissions for `bootstrap/cache` and `storage` directories.

## How to use
1. In API Id field enter valid `app_id` from [Сurrent weather and forecast - OpenWeatherMap](http://openweathermap.org/);
2. In City field enter any city;
3. Press „Submit“ and after that you should see new tab with city name.