#!/bin/bash

    #Update package index
    echo "Update Package"   
    sudo apt-get update -y
    #Setup git
    echo "Setup git"
    sudo apt-get install git -y
    #Setup Webserver
    echo "Install Webserver using apache2"    
    sudo apt-get install -y apache2 php php-mysql 
    #Setup Database Server
    echo "Install MariaDb"  
    sudo apt-get install -y mariadb-server
    #Setup phpmyadmin GUI
    echo "Install PhpMyadmin"
    sudo apt-get install -y phpmyadmin php-mbstring php-gettext 
    #Setup folder untuk webserver
    sudo mkdir -p /var/www/kelascilsy.local/public_html
    sudo mkdir -p /var/www/miniclass.local/public_html
    sudo mkdir -p /var/www/irfan.local/public_html
    #Setup membuat permission
    sudo chown -R $USER:$USER /var/www/kelascilsy.local/public_html
    sudo chown -R $USER:$USER /var/www/miniclass.local/public_html
    sudo chown -R $USER:$USER /var/www/irfan.local/public_html
    sudo chmod -R 755 /var/www/
    #Setup  virtual host
    sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/kelascilsy.local.conf
    sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/miniclass.local.conf
    sudo cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/irfan.local.conf
    #add admin user
    sudo mysql --host=localhost --user=root --password= << EOF
    CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin';
    GRANT ALL PRIVILEGES ON * . * TO 'admin'@'localhost';
    SELECT user.host FROM mysql.user;
    \q
EOF
    #add database for wordpress
    sudo mysql --host=localhost --user=admin --password=admin<< EOF
    CREATE database wordpress;
    show databases;
    \q
EOF
    #clone wordpress to local
    sudo git clone https://github.com/irfanrizkiantopratama/wordpress.git
    #copy file wordpress to DocumentRoot
    cd wordpress/public_html/
    sudo cp  -R * /var/www/miniclass.local/public_html
    sudo cp  -R * /var/www/kelascilsy.local/public_html
    sudo cp  -R * /var/www/irfan.local/public_html
    #check syntax apache2
    sudo apache2ctl configtest
    #reload & restart apache2
    sudo systemctl reload apache2
    sudo systemctl restart apache2


