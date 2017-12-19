# Backend

> Social Sharer Counter project done with Silex and CQRS principles

## Requeritments

> PHP 7.1+
> A SQL database (use Doctrine ORM)

## Build Setup

``` bash
# go to the backend
cd backend

# install dependencies
composer install

# create SQLite file
mkdir database
touch database/db.sqlite
sudo chmod +x database/db.sqlite

# create de SQL database
php vendor/bin/doctrine orm:schema-tool:create

# edit Apache conf to add port 8081 and the backend virtual host
sudo vim /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf
```

> Content to add to ports.conf
``` apacheconfig
Listen 8081
```

> Content to add to 000-default.conf
``` apacheconfig
<VirtualHost *:8081>
    ServerName localhost
    DocumentRoot /var/www/social-shared-counter/backend/src/Infrastructure/UI/WebSite/Public/
    
    Header always set Access-Control-Allow-Origin "*"
    Header always set Access-Control-Allow-Methods "POST, GET, OPTIONS, DELETE, PUT, PATCH"
    Header always set Access-Control-Max-Age "1000"
    Header always set Access-Control-Allow-Headers "x-requested-with, Content-Type, origin, authorization, accept, client-security-token"

    # Added a rewrite to respond with a 200 SUCCESS on every OPTIONS request.
    RewriteEngine On
    RewriteCond %{REQUEST_METHOD} OPTIONS
    RewriteRule ^(.*)$ $1 [R=200,L]

    <Directory /var/www/social-shared-counter/backend/src/Infrastructure/UI/WebSite/Public>
        Options +FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

## Access to backend site

> URL: http://localhost:8081

## Test backend site

> Download the Chrome extension [Restlet Client - REST API Testing](https://chrome.google.com/webstore/detail/restlet-client-rest-api-t/aejoelaoggembcahagimdiliamlcdmfm)
> Import in the Restlet Client extension the file backend/restlet-client.json
> Run the queries

## TODOs

> Extract counter of last tweets that contain de URL in TwitterService
> Add services Linkedin and Google+

# Frontent

> A Vue.js project to be the client of social shared counter

## Build Setup

``` bash
# install dependencies
npm install

# serve with hot reload at localhost:8080
npm run dev

# build for production with minification
npm run build

# build for production and view the bundle analyzer report
npm run build --report

# run unit tests
npm run unit

# run e2e tests
npm run e2e

# run all tests
npm test
```

# Video demo

> See the video demo.ogv to see the app working.