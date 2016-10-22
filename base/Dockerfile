FROM ubuntu:latest

RUN apt-get update
RUN apt-get install -y software-properties-common
RUN add-apt-repository ppa:ondrej/php -y
RUN apt-get update
RUN apt-get install -y --allow-unauthenticated apache2 php5.6 php5.6-mysql php5.6-mcrypt php5.6-xml php5.6-mbstring php5.6-curl php5.6-zip libapache2-mod-php5.6 mysql-client git

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
