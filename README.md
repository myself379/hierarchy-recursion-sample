Simply pull this repo and run

```
composer install
```

configure the .env file then migrate the database

```
php artisan migrate --seed
```

then run phpunit
```
./vendor/phpunit/phpunit/phpunit
```