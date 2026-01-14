---
error
/var/log/apache2/error.log
ls -la
---

-----
check api for wordpress plugin
curl -X GET "https://visitmyjoburg.co.za/api/get-social-posts"   -H "Accept: application/json"

----
sql command for better search replace in database
wp search-replace 'https://thevapeokes.com' 'https://thevapeokes.visitmyjoburg.co.za' --skip-columns=guid

---
import mysql file
mysql -u root -p deeplyrooted < deeplyrooted.sql
--
sudo nano /etc/apache2/ports.conf
Listen 80
Listen 8001
sudo nano /etc/hosts
--
Start server 
php artisan serve --port=8001
php artisan serve --host=127.0.0.2 --port=80
--
sudo lsof -t -i:8000
kill -9 1234
--
single command
sudo fuser -k 8000/tcp
--

---
Set timezone
---
sudo timedatectl set-timezone Africa/Johannesburg
timedatectl 
---

Set up cron jobs
---
sudo apt update
sudo apt install cron
sudo systemctl enable cron
sudo systemctl start cron

crontab -e
* * * * * cd /var/www/iampromoter && /usr/bin/php artisan schedule:run >> /dev/null 2>&1


---
Laravel start-up commands
--
chown -R www-data storage
chown -R www-data bootstrap/cache
cp .env.example .env
php artisan storage:link
php artisan key:generate
php artisan migrate
composer install --optimize-autoloader --no-dev


LAMP Stack with laravel full linux installation guide

---
Step 1: Install and connect to your machine using ssh be sure to create or upload your id_rsa.pub file and add it to autherized_keys
--

sudo apt update

sudo apt install openssh-server -y
chmod 700 ~/.ssh
chmod 600 ~/.ssh/authorized_keys
sudo ufw allow ssh
sudo ufw allow 22/tcp
sudo ufw allow 8080/tcp
sudo systemctl start ssh
sudo systemctl enable ssh
sudo ufw status
sudo systemctl restart ssh
sudo ufw enable

(Set pubkey authentication = yes)
/etc/ssh/sshd_config

rm ~/.ssh/known_hosts
---
Step 2: Install apache to deliver your website 
---
sudo apt install apache2 -y
sudo ufw allow 'Apache'
sudo ufw allow 'Apache Full'

---
Step 3: install mysql as a database this works with phpmyadmin
--
sudo apt install mysql-server -y
sudo mysql_secure_installation
sudo systemctl start mysql
sudo systemctl enable MySQL

create user 'api'@'localhost' identified by '1!Api123';
create database api;
GRANT ALL PRIVILEGES ON api.* TO 'api'@'localhost';
flush privileges;
exit;

---
Step 4: Install php and relevent extentions for laravel
--

sudo apt update
sudo apt install software-properties-common -y
sudo add-apt-repository ppa:ondrej/php -y
sudo apt install php8.2 php8.2-cli php8.2-common php8.2-gd php8.2-mbstring php8.2-xml php8.2-curl php8.2-mysql php8.2-gd php8.2-zip php8.2-bcmath php8.2-soap php8.2-readline php8.2-intl php8.2-tokenizer php8.2-fileinfo -y

sudo update-alternatives --set php /usr/bin/php8.2

php -m | grep -E 'gd|dom'

---
Step 5: Install phpmyadmin to better navigate your database (remove for production)
--
sudo apt install phpmyadmin -y
sudo ln -s /etc/phpmyadmin/apache.conf /etc/apache2/conf-available/phpmyadmin.conf
sudo a2enconf phpmyadmin


sudo dpkg --configure -a

sudo apt purge phpmyadmin -y
sudo apt autoremove --purge -y
sudo rm -rf /etc/phpmyadmin
sudo rm -rf /usr/share/phpmyadmin
sudo rm -f /etc/apache2/conf-available/phpmyadmin.conf

---
Step 6: Install php composer the package manager for php  
--

php -m
sudo a2enmod rewrite
sudo service apache2 restart
cd /usr/bin
curl -sS https://getcomposer.org/installer | sudo php
sudo mv composer.phar composer
composer

sudo update-alternatives --set php /usr/bin/php8.2

---
Step : Install the latest nodejs version to your machine, update your source packages
--
sudo apt remove nodejs npm
sudo apt clean
sudo apt autoremove
sudo apt purge nodejs
curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -
sudo apt-get install -y nodejs
sudo apt install npm

---
Another step: If your installing wordpress to your machine 
--

sudo a2enmod rewrite
wget https://wordpress.org/latest.zip
sudo install unzip

sudo chown -R www-data:www-data /var/www/wordpress
cd /var/www/wordpress
find . -type d -exec chmod 755 {} \;
find . -type f -exec chmod 644 {} \;
sudo chown -R www-data:www-data
chmod 600 wp-config-sample.php

mv /var/www/wordpress/wp-config-sample.php /var/www/wordpress/wp-config.php


memory_limit=256M
upload_max_filesize=64M
post_max_size=64M
max_execution_time=300
max_input_vars=2000
max_input_time=1000

1. starter templates
2. pro-elements


---
step 8: Install and authenticate with GitHub
--
sudo apt install git
sudo apt install gh -y
gh auth login

---
Another step: when creating your .conf file under /etc/apache/sites-enabled be sure to give url permissions like below
--
<Directory /var/www/wordpress>
     Options Indexes FollowSymLinks MultiViews
     AllowOverride All
     Require all granted
</Directory>

---
step 9: Install certbot for you lets encrypt ssl certificates
--
sudo apt install certbot python3-certbot-apache -y
sudo certbot --apache

---
If your running on a different port
--
sudo nano /etc/apache2/ports.conf
sudo ufw status verbose
Listen 8081 (add this to line)
sudo a2ensite demo.conf (shortcut to enable .conf files)
--
sudo a2enmod ssl

---
refresh laravel application
--
php artisan config:cache
php artisan config:clear
php artisan view:clear
php artisan cache:clear

sudo systemctl restart ufw apache2 mysql ssh

php artisan clear-compiled
composer dump-autoload

php artisan route:list

---
mysql commands
--
SELECT User, Host FROM mysql.user;

CREATE USER 'theadminuser'@'localhost' IDENTIFIED BY '1!Theadminuser123';
GRANT ALL PRIVILEGES ON wordpress.* TO 'theadminuser'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'external'@'localhost';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM 'external'@'localhost';
sudo ufw allow 3306/tcp
sudo ufw reload
GRANT INSERT ON api.social_posts TO 'external'@'localhost';
sudo apt update && sudo apt install net-tools -y
mysqladmin -h 34.35.77.194 -u external -p ping



--------------
ssh-keygen -t ed25519 -C "alecshelembe@gmail.com"
sudo apt install espeak

npx tailwindcss -o public/css/output.css

curl -X GET "https://thevapeokes.com/wp-json/visitmyjoburg/v1/info?key=https://visitmyjoburg.co.za';
    $secret_key = '1qazsw34edc" \
     -H "Origin: https://visitmyjoburg.co.za"


---------------
Android studio and react native
---------------
npx expo start --no-dev --minify 
npx expo start --tunnel
expo prebuild
expo run:android
