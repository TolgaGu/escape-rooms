## Author
Tolga GÜREL

<h1>Installation<h2>

## install project
composer install

## create .env file
cp .env.example .env

## create database.sqlite
touch database/database.sqlite

## update DB_DATABASE in .env file with the absolute path for database.sqlite
ex : DB_DATABASE=var/www/html/escape-room/database/database.sqlite

php artisan migrate:fresh
## 
php artisan db:seed
## 
php artisan serve  

## Test user
email : test@test.com
password : mysecurepassword

## POSTMAN
Add to postman "EscapeRooms.postman_collection" file present in root directory to execute api requests with tests