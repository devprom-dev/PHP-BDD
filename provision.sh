#!/usr/bin/env bash
SELENIUM_PATH=/opt/selenium-server-standalone.jar

set -e

if [ "$(id -u)" != "0" ]; then
   echo "This script must be run as root" 1>&2
   exit 1
fi

echo "# Installing system requirements"
apt install software-properties-common
add-apt-repository ppa:ondrej/php
apt-get update
apt-get install -y apt-transport-https ca-certificates linux-image-extra-$(uname -r) linux-image-extra-virtual xvfb mysql-client php5.6 php5.6-mysql php5.6-mcrypt php5.6-xml php5.6-mbstring php5.6-curl php5.6-zip python-pip openjdk-8-jre-headless libgtk-3-0 libasound2

echo "# Installing firefox "
wget https://sourceforge.net/projects/ubuntuzilla/files/mozilla/apt/pool/main/f/firefox-mozilla-build/firefox-mozilla-build_47.0.1-0ubuntu1_amd64.deb -O firefox.deb
dpkg -i firefox.deb

echo "# Installing composer"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php -r "if (hash_file('SHA384', 'composer-setup.php') === 'e115a8dc7871f15d853148a7fbac7da27d6c0030b848d9b3dc09e2a0388afed865e6a3d6b3c0fad45c48e2b5fc1196ae') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
php composer-setup.php
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer

echo "# Installing docker and jenkins"
wget -q -O - https://pkg.jenkins.io/debian/jenkins-ci.org.key | apt-key add -
apt-key adv --keyserver hkp://p80.pool.sks-keyservers.net:80 --recv-keys 58118E89F3A912897C070ADBF76221572C52609D
echo "deb http://pkg.jenkins.io/debian-stable binary/" > /etc/apt/sources.list.d/jenkins.list
echo "deb https://apt.dockerproject.org/repo ubuntu-xenial main" > /etc/apt/sources.list.d/docker.list
apt-get update
apt-get install -y docker-engine jenkins
usermod -aG docker ${SUDO_USER}
usermod -aG docker jenkins
pip install docker-compose

echo "# Installing selenium, geckodriver"
wget https://github.com/mozilla/geckodriver/releases/download/v0.10.0/geckodriver-v0.10.0-linux64.tar.gz
tar -xzf geckodriver-v0.10.0-linux64.tar.gz
mv geckodriver /usr/bin
wget -O ${SELENIUM_PATH} http://selenium-release.storage.googleapis.com/2.53/selenium-server-standalone-2.53.1.jar

echo "# Configuring services"
cat > /etc/init.d/xvfb <<EOL
#!/bin/sh
XVFB=/usr/bin/Xvfb
XVFBARGS=":99 -screen 0 1024x768x24 -ac +extension GLX +render -noreset -nolisten tcp"
PIDFILE=/var/run/xvfb.pid
case "\$1" in
  start)
    echo -n "Starting virtual X frame buffer: Xvfb"
    start-stop-daemon --start --quiet --pidfile \$PIDFILE --make-pidfile --background --exec \$XVFB -- \$XVFBARGS
    echo "."
    ;;
  stop)
    echo -n "Stopping virtual X frame buffer: Xvfb"
    start-stop-daemon --stop --quiet --pidfile \$PIDFILE
    echo "."
    ;;
  restart)
    \$0 stop
    \$0 start
    ;;
  *)
        echo "Usage: /etc/init.d/xvfb {start|stop|restart}"
        exit 1
esac

exit 0
EOL

cat > /etc/init.d/selenium <<EOL
#!/bin/sh
JAVA_BIN=/usr/bin/java
PID_FILE="/var/run/selenium.pid"
JAR_FILE="${SELENIUM_PATH}"

DAEMON_OPTS=" -jar \$JAR_FILE"

NAME=selenium

export DISPLAY=:99

case "\$1" in
    start)
        echo -n "Starting \$DESC: "
        start-stop-daemon --start --background --pidfile \$PID_FILE --make-pidfile --exec \$JAVA_BIN -- \$DAEMON_OPTS
        echo "\$NAME."
        ;;

    stop)
        echo -n "Stopping \$DESC: "
        start-stop-daemon --stop --pidfile \$PID_FILE
        echo "\$NAME."
        ;;

    restart|force-reload)
        echo -n "Restarting \$DESC: "
        start-stop-daemon --stop --pidfile \$PID_FILE
        sleep 1
        start-stop-daemon --start --background --pidfile \$PID_FILE  --make-pidfile --exec \$JAVA_BIN -- \$DAEMON_OPTS
        echo "\$NAME."
        ;;

    *)
        N=/etc/init.d/\$NAME
        echo "Usage: \$N {start|stop|restart|force-reload}" >&2
        exit 1
        ;;
esac
EOL

chmod +x /etc/init.d/selenium
chmod +x /etc/init.d/xvfb

update-rc.d selenium defaults
update-rc.d xvfb defaults

echo "# Starting services"
service xvfb start
service selenium start
service jenkins restart
