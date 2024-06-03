## How to start:
    Project builded on Laravel 11
- run `docker-compose up --build`
- enter to container `docker-compose exec app bash`:
    **run**`composer install` and `npm run build`
- update .env DB connection
- from App container run `php artisan migrate`, `import:trips_data_from_csv`
- run `php artisan storage:link`