Yii 2 API application
===============================

API application for getting currency rates

Run
-------------------
Clone a project
```
git clone git@github.com:Ivanitch/yii2-currency.git .
```
Run the project in docker
```
# Copy the files to run docker compose
cp ./.env.dist ./.env
cp ./docker/nginx/conf.d/site.conf.dist ./docker/nginx/conf.d/site.conf

# Run containers build
make build

# Connect to the server
make server
```
Copy config file and connect to database
```
cp ./common/config/main-local.php.dist ./common/config/main-local.php
```
Install dependencies
```
composer update

# On the production server
composer install --no-dev --optimize-autoloader --classmap-authoritative
```
Run migrations.
```
php yii migrate
```
When creating **init** migration, the **admin** user is created with the **admin** password
Assign the **admin** role to the **admin** user
```
$ php yii role/assign
Username: admin
Role: [admin,user,?]: admin
Done!
```




Authorization
----------------------
Request a token
```
curl -X POST "Accept: application/json" -d "username=admin&password=admin" http://app.loc/auth
```
Get the token and timestamp when it expires

Profile
```
curl -H "Authorization: Bearer <token>" http://app.loc/profile
```
Get all currencies
```
curl -H "Authorization: Bearer <token>" http://app.loc/currencies
```
Currency rate by ID
```
curl -H "Authorization: Bearer <token>" http://app.loc/currencies/11
```
Updating currencies from the console
```
php /var/project/yii currency/update
```
Updating Cron Data
```
31 13 * * * php /var/project/yii currency/update
```
Data is automatically updated at 13.31 (Moscow time)

Tests
----------------------
Specify url in the config file
```
cp tests/api.suite.yml.dist tests/api.suite.yml
```
Run tests
```
./vendor/bin/codecept run "tests/api" --steps
```