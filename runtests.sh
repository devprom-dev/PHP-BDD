#!/bin/bash
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create
docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force
docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load
docker exec `docker ps -q -f name=.base.` bin/phpunit -c app/
cd base/php-bdd/
bin/behat --config app/config/behat.yml
