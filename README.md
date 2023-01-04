[![Actions Status](https://github.com/BotServicePro/php-project-lvl4/workflows/hexlet-check/badge.svg)](https://github.com/BotServicePro/php-project-lvl4/actions) <a href="https://codeclimate.com/github/BotServicePro/php-project-lvl4/maintainability"><img src="https://api.codeclimate.com/v1/badges/ddcccc91bc76aa67f182/maintainability" /></a>
<a href="https://codeclimate.com/github/BotServicePro/php-project-lvl4/test_coverage"><img src="https://api.codeclimate.com/v1/badges/ddcccc91bc76aa67f182/test_coverage" /></a>

## Laravel Task Manager is my fourth project from Hexlet!

### Descripion:
Task Manager application is a simple project, which allows you to create/read/update/delete tasks,
labels/tags for tasks, change executors data, check task statuses. In this project is shown how to use auth policies, o2m/m2m ORM relations, db seeders.
Also used Eloquent requests. Forms was made with LaravelCollective forms.

### Requrements:
<li> PHP ^7.3
<li> Laravel 8
<li> Composer
<li> SQLite for testing
<li> Database: PostgreSQL
<li> PHPUnit
<li> <a href="https://devcenter.heroku.com/articles/heroku-cli#download-and-install">Heroku CLI</a>

### Installation:
```
git clone https://github.com/BotServicePro/php-project-lvl4.git
cd php-project-lvl4
make start
make migrate
```
### Demo data:
```
php artisan db:seed TaskStatuseSeeder
php artisan db:seed LabelSeeder
php artisan db:seed UserSeeder
php artisan db:seed TaskSeeder
```
