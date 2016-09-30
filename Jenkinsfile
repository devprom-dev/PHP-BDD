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
            docker exec `docker ps -q -f name=.base.` /root/wait-for-it.sh -t 120 mysql:3306 --
        '''
    }
    stage('Create database and run tests') {
        sh '''
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:drop --force --if-exists
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:database:create
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:schema:update --force
            docker exec `docker ps -q -f name=.base.` php app/console doctrine:fixtures:load --fixtures=src/PHPBDD/PosterBundle/Tests/DataFixtures/ORM
            docker exec `docker ps -q -f name=.base.` bin/phpunit -c app/
            cd ./behat-tests/
            composer install
            bin/behat
        '''
    }
    stage('Stop docker containers') {
        sh '''
            docker-compose stop
            # Uncomment this to delete unnecessary images
            # docker ps --filter status=dead --filter status=exited -aq | xargs -r docker rm -v
            # docker images --no-trunc | grep '<none>' | awk '{ print $3 }' | xargs -r docker rmi
            # docker volume ls -qf dangling=true | xargs -r docker volume rm
        '''
    }
}
