# Simple application for managing projects, written in tdd methodology

## Installation

### 1. clone repo:
###### `git clone https://github.com/mich220/laravel_tdd.git`

### 2. install dependencies:
###### `composer install`
###### `npm install`

### 3. set env variables:
###### `cp .env.example .env`
###### set APP_URL and connection to database in .env file 

### 4. generate key:
###### `php artisan key:generate`

### 5. run migrations:
###### `php artisan migrate:fresh --seed`

### 6. serve application (dev only):
###### `php artisan serve`

### tests:
###### `phpunit` or `vendor/bin/phpunit`
