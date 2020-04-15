[![codecov](https://codecov.io/gh/wyster/symfony-based-vehicle-search/branch/master/graph/badge.svg)](https://codecov.io/gh/wyster/symfony-based-vehicle-search)

# Запуск проекта

Проект можно запустить через docker-compose, для этого нужно

* Перейти в директорию `.docker` : `cd .docker`

* Запустить команду `make setup`

* Отредактировать `.env`, а именно порты по которым будет доступен веб сервер

```
HTTP_PORT=80
MYSQL_PORT=3306
````

* Запустить контейнеры

`make up`

Подьём может занят время, устанавливаются пакеты composer, отследить процесс можно через `make logs`

* После того как все контейнеры запущены проверить работу обратившись через браузер по `http://localhost:$HTTP_PORT`

* Запустить загрузку фикстур `docker-compose run php ./bin/console doctrine:fixtures:load` (подвердить через y)

* К базе можно подключиться по `localhost:$DB_PORT`, login: `dev`, password: `dev`

Другие доступные команды можно посмотреть выполнив `make`