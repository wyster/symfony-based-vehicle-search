#!/bin/bash

if [ $COMPOSER_INSTALL == "1" ]; then
    composer global require hirak/prestissimo
    composer install --prefer-dist --no-progress --no-suggest
fi

if [ $ENABLE_XDEBUG == "1" ]; then
    docker-php-ext-enable xdebug
fi

chmod 0777 ./tests/_output -R

bash /wait-for.sh mysql:3306 -t 0 -- echo "Mysql started"

docker-php-entrypoint php-fpm
