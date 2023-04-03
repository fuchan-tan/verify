
## About Verify

Simple API to verify POST JSON information and store result records on database. 

## Requirements
* [Git](https://github.com/fuchan-tan/laravel-verify
* PHP 8.1+
* [Composer](https://getcomposer.org/)
* [MySQL](https://www.mysql.com/)

## Installation
1. Clone git repository
2. Run Composer update
3. Create .env file fro .envexample
4. Generate application encryption key (php artisan key:generate)
5. Migrate table (php artisan migrate)
6. The post method can be test at SERVERNAME/api/v1/verify/ with JSON 