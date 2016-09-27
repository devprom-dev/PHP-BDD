#!/bin/bash
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create
docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force
docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load --fixtures=src/PHPBDD/PosterBundle/Tests/DataFixtures/ORM
docker exec `docker ps -q -f name=.base.` bin/phpunit -c app/
cd behat-tests/
composer install
bin/behat
