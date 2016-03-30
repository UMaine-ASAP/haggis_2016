#!/usr/bin/env bash

echo "--- Huh? Oh hey there! Yeahhh—oh yeah! Ok let’s get started! ---"

echo "--- Updating packages list ---"
sudo apt-get update

echo "--- Everybody love MySQL ---"
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password password root'
sudo debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password root'

echo "--- Installing base packages ---"
sudo apt-get install -y vim curl python-software-properties

echo "--- Don’t cut yourself on that PHP, it’s bleeding edge (PHP 5 that is...)! ---"
sudo add-apt-repository -y ppa:ondrej/php5

echo "--- Updating packages list ---"
sudo apt-get update

echo "--- Installing PHP-specific packages ---"
sudo apt-get install -y php5 apache2 libapache2-mod-php5 php5-curl php5-gd php5-mcrypt mysql-server-5.5 php5-mysql git-core

echo "--- Installing and configuring Xdebug ---"
sudo apt-get install -y php5-xdebug

cat << EOF | sudo tee -a /etc/php5/mods-available/xdebug.ini
xdebug.scream=1
xdebug.cli_color=1
xdebug.show_local_vars=1
EOF

echo "--- Enabling mod-rewrite ---"
sudo a2enmod rewrite

echo "--- You’re about to get served, setting document root ---"
sudo rm -rf /var/www
sudo ln -fs /vagrant /var/www


echo "--- What developer codes without errors turned on? ---"
sed -i "s/error_reporting = .*/error_reporting = E_ALL/" /etc/php5/apache2/php.ini
sed -i "s/display_errors = .*/display_errors = On/" /etc/php5/apache2/php.ini

sed -i 's/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf
# sed -i 's/html//' /etc/apache2/sites-available/000-default.conf
# sed -i 's/html//' /etc/apache2/sites-available/000-default.conf
sudo cp "/vagrant/vagrant-bootstrap/000-default.conf" "/etc/apache2/sites-available/000-default.conf"

echo "--- Hold your breath! Restarting Apache ---"
sudo service apache2 restart

echo "--- Every great song needs a composer. Same with php software. ---"
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

echo "--- Setup custom commands ---"

echo 'cd /vagrant' >> /home/vagrant/.bashrc

cd /vagrant
sudo composer install


echo "--- Go forth and conquer! ---"

#Upgrade to mysql-server 5.6
#import https://rtcamp.com/tutorials/mysql/mysql-5-6-ubuntu-12-04/
# apt-get install libaio1 libaio-dev
# running mysql process sudo mysqld_safe --user=mysql &
echo "--- Oh, and don't forget to start mysql :) ---"
sudo -u mysql /etc/init.d/mysql.server start

sudo mysql -u root -proot < /vagrant/vagrant-bootstrap/structure.sql
