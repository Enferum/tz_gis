## How to start:
    Project builded on Laravel 11
- run `docker-compose build`
- `cp .env .env.example`
- update .env DB connection
##
- run `docker-compose up -d`
- enter to container `docker-compose exec app bash`:
  **run**`composer install` and `npm run build`
- `php artisan key:gen` inside **app container**
##
- from App container run `php artisan migrate`, `import:trips_data_from_csv`
- run `php artisan storage:link`