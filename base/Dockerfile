FROM ubuntu:latest

RUN apt-get update && apt-get install -y apache2 php7.0 libapache2-mod-php7.0 mysql-client php7.0-mysql php7.0-mcrypt php-xml php-mbstring php-curl php-zip git

COPY php.ini /usr/local/etc/php/
COPY phpbdd.conf /etc/apache2/sites-available/
COPY php-bdd /var/www/repo/
COPY parameters.yml /var/www/repo/app/config/

RUN a2enmod rewrite
RUN a2ensite phpbdd
RUN service apache2 restart

WORKDIR /var/www/repo

RUN rm -fr app/cache/*
RUN rm -fr app/logs/*

RUN rm -f /var/run/apache2/apache2.pid

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data

RUN chmod 777 app/cache
RUN chmod 777 app/logs
RUN chmod 777 web/images

ENV TZ=Asia/Bishkek
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

CMD /usr/sbin/apache2ctl -D FOREGROUND
