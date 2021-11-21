# php-project-lvl4
[![Actions Status](https://github.com/BotServicePro/php-project-lvl4/workflows/hexlet-check/badge.svg)](https://github.com/BotServicePro/php-project-lvl4/actions) <a href="https://codeclimate.com/github/BotServicePro/php-project-lvl4/maintainability"><img src="https://api.codeclimate.com/v1/badges/ddcccc91bc76aa67f182/maintainability" /></a>
<a href="https://codeclimate.com/github/BotServicePro/php-project-lvl4/test_coverage"><img src="https://api.codeclimate.com/v1/badges/ddcccc91bc76aa67f182/test_coverage" /></a>
[![Heroku App Status](http://heroku-shields.herokuapp.com/karakin-php-project-lvl4)](https://karakin-php-project-lvl4.herokuapp.com)


# <a href="https://karakin-php-project-lvl4.herokuapp.com/">Demo</a>

# NOT READY YET

make start<br>
make migration<br>
php artisan db:seed UserSeeder<br>
php artisan db:seed TaskStatuseSeeder<br>
php artisan db:seed TaskSeeder<br>
php artisan db:seed LabelSeeder<br>



Создаем миграцию + модель + контроллер<br>
<code>php artisan make:model Label --migration --controller</code>

Создаём ресурсный роутинг - <br>
<code>php artisan make:controller TaskStatusController --resource --model TaskStatus</code><br>
Создаём политики - <br>
<code>php artisan make:policy TaskStatusPolicy --model=TaskStatus</code>


USAGES<br>
laravel-query-builder<br>
rollbar-laravel<br>
