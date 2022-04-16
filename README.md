## Конфиг
* **php** = 8.0-fpm
* **nginx** = 1.17
* **postgres** = 12

## Описание
На виндовс приложение в докере работает с задержкой, на линукс такого нет.


## Запуск на виндовс

Пишем в корневой директории в консоли

`docker-compose up --build -d`

после сборки докер контейнеров, вводим по очереди в командной строке:

`docker exec -it ajax-comments-php-fpm composer install`

`cp -n .env.example .env || true`

`php artisan key:generate`

`docker exec -it ajax-comments-php-fpm php artisan migrate`


Проверяем в браузере [localhost:8086](http://localhost:8086/)

## Возможные проблемы на Windows
При запуске команды появляется такая ошибка 
`the input device is not a TTY.  If you are using mintty, try prefixing the command with 'winpty'`
Выполняем команду с префиксом `'winpty'`

например, было `php run` будет `winpty php run`



## Запуск на linux

`make setup`

`make install`


Далее на unix системах нужно добавить права на папки

`/storage/logs` и `/storage/frameworks` и `/bootstrap/cache`,

для этого нужно выполнить пункты из раздела `Возможные проблемы`

Проверяем в браузере [localhost:8086](http://localhost:8086/)

## Возможные проблемы на Linux

Если проект не запускается на linux, скорее всего проблемы с доступам к папкам,
`/storage/logs` и `/storage/frameworks` и `/bootstrap/cache`, .
Заходим на пк через терминал в корневую дерикторию и делаем следующее.


Заходим в корень проекта пишем:

`sudo chown -R $USER:$USER .`

`sudo chmod -R 775 .`

`sudo chmod -R 775 storage`

`sudo chmod -R ugo+rw storage`

далее:

`sudo chown -R www-data:www-data ./storage/logs/`

`sudo chown -R www-data:www-data ./storage/framework/`

`sudo chown -R www-data:www-data ./bootstrap/cache`

`sudo chmod -R 775 ./bootstrap/cache`

Если все равно остались проблемы, пишем в консоли

`sudo chown -R $USER:www-data storage`

`sudo chown -R $USER:www-data bootstrap/cache`

Затем

`chmod -R 775 storage`

`chmod -R 775 bootstrap/cache`


