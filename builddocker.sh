#!/bin/bash
cp parameters.yml base/php-bdd/app/config/
cd base/php-bdd/
composer install
cd ../../
docker-compose up -d --build
docker exec `docker ps -q -f name=repo_base_1` php app/console doctrine:database:drop --force --if-exists
docker exec `docker ps -q -f name=repo_base_1` php app/console doctrine:database:create
docker exec `docker ps -q -f name=repo_base_1` php app/console doctrine:schema:update --force
docker exec `docker ps -q -f name=repo_base_1` php app/console doctrine:fixtures:load
