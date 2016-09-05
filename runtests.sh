#!/bin/bash
php app/console doctrine:database:drop --force --env=test
php app/console doctrine:database:create --env=test
php app/console doctrine:schema:update --force --env=test
php app/console doctrine:fixtures:load --env=test --append
bin/phpunit -c app/
php app/console server:start 127.0.0.1:7777 --env=test
bin/behat --config app/config/behat.yml
php app/console server:stop 127.0.0.1:7777