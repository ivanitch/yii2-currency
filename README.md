Yii2 API application
===============================

API application for getting currency rates

Run
-------------------
Clone a project
```shell
git clone git@github.com:Ivanitch/yii2-currency.git .
```
Run the project in docker
```shell
# Copy the files to run docker compose
cp ./.env.dist ./.env
cp ./docker/nginx/conf.d/site.conf.dist ./docker/nginx/conf.d/site.conf

# Run containers build
make build

# Connect to the server
make server
```
Copy config file and connect to database
```shell
cp ./common/config/main-local.php.dist ./common/config/main-local.php
```
Install dependencies
```shell
composer update

# On the production server
composer install --no-dev --optimize-autoloader --classmap-authoritative
```
Run migrations.
```shell
php yii migrate
```
When creating **init** migration, the **admin** user is created with the **admin** password
Assign the **admin** role to the **admin** user
```shell
$ php yii role/assign
Username: admin
Role: [admin,user,?]: admin
Done!
```
Authorization
----------------------
Request a token
```shell
curl -X POST "Accept: application/json" -d "username=admin&password=admin" http://app.loc/auth
```
Get the token and timestamp when it expires

Profile
```shell
curl -H "Authorization: Bearer <token>" http://app.loc/profile
```
Get data on currencies
----------------------
Get all currencies
```shell
http://app.loc/currencies
```
Currency rate by NumCode or CharCode
```shell
http://app.loc/currencies/usd
# OR
http://app.loc/currencies/840
```
Updating currencies from the console
```shell
php yii currency/update
```
CRON
----------------------
Updating exchange rate data via Cron
```shell
# Data is automatically updated at 12.00 (Moscow time)
0 12 * * * /usr/bin/php /var/project/yii currency/update
```
