#!/bin/bash
cp parameters.yml base/php-bdd/app/config/
cd base/php-bdd/
composer install
cd ../../
docker-compose build
docker-compose up -d
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists
docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create
docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force
docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load --fixtures=src/PHPBDD/PosterBundle/Tests/DataFixtures/ORM
