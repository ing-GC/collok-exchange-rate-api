## Config

Dependences
- PHP 8.1
- Laravel 9.8.1

1.- Clone the project
```
git clone https://github.com/ing-GC/collok-exchange-rate-api.git
```
2.- Rename the .env.example to .env
3.- Modify the name of DB
```
DB_DATABASE=collok-api
```
4.- Add the Fixer.io key and Banxico token into .env
```
FIXER_ACCESS_KEY=your-access-key
BMX_TOKEN=your-token
```
5.- Run
```
composer install
```
6.- Run
```
php artisan migrate:fresh --seed
```
7.- Generate keys
```
php artisan key:generate
php artisan passport:install --force
```
8.- Add the project in hosts file (optional step)
```
127.0.0.1       collok-api.test
```
or run 
```
php artisan serve
```
##Unit Test
Run
```
mkdir tests/Unit
php artisan test
```

##Manual Test

All request need the Accept: application/json header.

- Register endpoint
<p>
<img src="public/img/register.PNG"/>
</p>
<p>
- Login endpoint
<img src="public/img/login.PNG"/>
<p>
</p>
- Exchanges rates endpoint
<img src="public/img/exchanges_rates.PNG"/>
</p>
*Note. The provider_1 (fixer.io) only permit with the free account exchange with EUR.