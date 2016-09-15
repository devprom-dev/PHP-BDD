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
            docker-compose up -d --build
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
        '''
        wrap([$class: 'Xvfb']) {
            sh '''
                cd base/php-bdd/
                bin/behat --config app/config/behat.yml
            '''
        }
    }
    stage('Stop and cleanup docker containers') {
        sh '''
            docker-compose stop
            docker ps --filter status=dead --filter status=exited -aq | xargs -r docker rm -v
            docker images --no-trunc | grep '<none>' | awk '{ print $3 }' | xargs -r docker rmi
            docker volume ls -qf dangling=true | xargs -r docker volume rm
        '''
    }
}
