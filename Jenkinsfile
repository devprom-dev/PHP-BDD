#!groovy
node {
    stage('Checkout') {
        def file = new File( 'parameter.yml' )
        while (!file.exists()) sleep(1)
        sh '''
            cp parameters.yml ./base/php-bdd/app/config/
            cd ./base/php-bdd/
            composer install
            cd ../../
            docker-compose up -d --build
            docker exec `docker ps -q -f name=php_bdd_base` php app/console doctrine:database:drop --force --if-exists
            docker exec `docker ps -q -f name=php_bdd_base` php app/console doctrine:database:create
            docker exec `docker ps -q -f name=php_bdd_base` php app/console doctrine:schema:update --force
            docker exec `docker ps -q -f name=php_bdd_base` php app/console doctrine:fixtures:load
        '''
    }
}
