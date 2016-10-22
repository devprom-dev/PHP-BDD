FROM ubuntu:latest

RUN apt-get update
RUN apt-get install -y apache2 php5 php5-mysql php5-curl mysql-client git

RUN rm -f /etc/apache2/sites-enabled/*
RUN rm -f /etc/apache2/sites-available/*

COPY php.ini /usr/local/etc/php/
COPY phpbdd.conf /etc/apache2/sites-available/
COPY php-bdd /var/www/repo/
COPY wait-for-it.sh /root/

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
