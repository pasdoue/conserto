FROM ubuntu

RUN apt-get -o Acquire::Check-Valid-Until=false update

# ###############################
# #   Installing apache server
# ###############################
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y apache2

# remove default index.html to provide website files
RUN rm /var/www/html/index.html
COPY build/website /var/www/html/

# dont forget permissions ;)
RUN chown -R www-data:www-data /var/www/html

# # ###############################
# # #   Installing PHP
# # ###############################
RUN DEBIAN_FRONTEND=noninteractive apt-get install -y php libapache2-mod-php php-mysql

# # ###############################
# # #   Installing MySQL
# # ###############################

RUN DEBIAN_FRONTEND=nonintercative apt-get install -y mysql-server mysql-client

# Load DB dump and script to configure account/pwd & schema
COPY build/conserto_challs.sql /tmp/conserto_challs.sql
COPY build/load_bdd.sh /tmp/load_bdd.sh
RUN /tmp/load_bdd.sh

# ###############################
# #   PostInstall
# ###############################

#CMD ["mysqld"]
CMD ["apache2ctl", "-D", "FOREGROUND"]


EXPOSE 80
EXPOSE 3306

# CMD apache2ctl start
