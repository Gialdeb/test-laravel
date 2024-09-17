# Laravel Test

#### Author: Giuseppe Alessandro De Blasio

## Tech Stack

* PHP 8.2
* MySQL/MariaDB
* [Laravel 11](https://github.com/laravel/laravel/tree/11.x)

# Package Dependencies

* [laravel/sail](https://laravel.com/docs/11.x/sail)
* [laravel/sanctum](https://laravel.com/docs/11.x/sanctum)
* [inertiajs/inertia-laravel](https://laravel.com/docs/11.x/frontend#inertiah)

## System Requirements

* [Docker](https://www.docker.com)

## Installation

* Copy `.env.sail` to `.env`
* Check `APP_PORT` to make sure it does not conflict with some local webserver instance on same port (`80`)
* Check `FORWARD_DB_PORT` to make sure it does not conflict with some local MySQL instance on same port (`3306`)
* Check `API_ENDPOINT` in case it's now different from default (https://api.openbrewerydb.org/v1/breweries)
* Install Laravel Sail with the following command (no need to have PHP 8.2 installed locally):

  ```shell
  docker run --rm \
      -u "$(id -u):$(id -g)" \
      -v "$(pwd):/var/www/html" \
      -w /var/www/html \
      laravelsail/php82-composer:latest \
      composer install --ignore-platform-reqs
  ```
* Bring containers up with:
  ```shell
  ./vendor/bin/sail up -d
  ```

* Run database migrations and seeds with:
  ```shell
  ./vendor/bin/sail artisan migrate:fresh --seed
  ```

## Development

* Run static analysis with:
  ```shell
  ./vendor/bin/sail php ./vendor/bin/rector
  ```
* Run code linting with:
  ```shell
  ./vendor/bin/sail php ./vendor/bin/duster lint
  ```
* Fix lint errors with:
  ```shell
  ./vendor/bin/sail php ./vendor/bin/duster fix
  ```

## Endpoints

* Login with `root@example.com` as an email and `password` as a password with (add `APP_PORT` to base URL if different from 80):

* After user is authenticated, fetch available beers from API using token from login response with (`page` defaults to 1 and `perPage` defaults to 20 if not specified):
  ```shell
  curl --location 'http://localhost/api/breweries?page=1&perPage=5' \
  --header 'Accept: application/json' 
  ```

## Testing

* Run tests and show code coverage with:
  ```shell
  ./vendor/bin/sail artisan test --coverage
  ```
