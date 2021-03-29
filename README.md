Yii 2 API application
===============================

API application for getting currency rates

Run
-------------------
Clone a project
```
git clone https://github.com/Ivanitch/yii2-api-currencies.git .
```
Copy config files and connect to database
```
cp common/config/main-local.php.dist common/config/main-local.php
```
Install dependencies
```
composer update
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
Configuring a virtual host in Apache
----------------------
```
<VirtualHost *:80>
ServerName api.example.com
DocumentRoot /var/www/html/example.com/api/
</VirtualHost>
```
Authorization
----------------------
Request a token
```
curl -X POST "Accept: application/json" -d "username=admin&password=admin" http://api.example.com/auth
```
Get the token and timestamp when it expires

Profile
```
curl -H "Authorization: Bearer <token>" http://api.example.com/profile
```
