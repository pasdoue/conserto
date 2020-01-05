#!/bin/bash

if [[ ! -d "/var/run/mysqld" ]]; then
    echo "Creating /var/run/mysqld directory"
    mkdir /var/run/mysqld
    chown -R mysql:mysql /var/run/mysqld
    service mysql restart
fi

MAINDB="conserto_challs"
DBUSER="pinkhat"
USER_PWD="FgTyJ1kd29!,"

mysql -u root -e "CREATE DATABASE ${MAINDB} /*\!40100 DEFAULT CHARACTER SET utf8 */;"
mysql -u root -e "CREATE USER ${DBUSER}@localhost IDENTIFIED BY '${USER_PWD}';"
mysql -u root -e "GRANT ALL PRIVILEGES ON ${MAINDB}.* TO '${DBUSER}'@'localhost';"
mysql -u root -e "FLUSH PRIVILEGES;"
mysql -u root "${MAINDB}" < /tmp/conserto_challs.sql
