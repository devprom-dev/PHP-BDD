#!groovy
node {
    stage('Checkout') {
        checkout scm
    }
    stage('Build docker containers') {
        sh '''
            cp parameters.yml ./base/php-bdd/app/config/
            cd ./base/php-bdd/
            composer install
            cd ../../
            docker-compose build
            docker-compose up -d
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load
        '''
    }
    stage('Create testdb and run tests') {
        sh '''
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists --env=test
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create --env=test
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force --env=test
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load --env=test
            docker exec `docker ps -q -f name=.base.` bin/phpunit -c app/
            cd base/php-bdd/
            bin/behat --config app/config/behat.yml
        '''
    }
    stage('Stop docker containers') {
        sh '''
            docker-compose stop
        '''
    }
}
