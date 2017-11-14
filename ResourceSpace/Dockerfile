FROM ubuntu:trusty
MAINTAINER Michael Steinacher (mstein921@googlemail.com)

# Install packages
ENV DEBIAN_FRONTEND noninteractive
RUN apt-get update && \
  apt-get -y install supervisor git apache2 libapache2-mod-php5 mysql-server php5-mysql pwgen php-apc php5-mcrypt \
  			php5-gd php5-mysql subversion imagemagick \
  			ghostscript antiword xpdf libav-tools libimage-exiftool-perl && \
  apt-get clean -y && \
  rm -rf /var/lib/apt/lists/* && \
  echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Add image configuration and scripts
ADD start-apache2.sh /start-apache2.sh
ADD start-mysqld.sh /start-mysqld.sh
ADD run.sh /run.sh
RUN chmod 755 /*.sh
ADD my.cnf /etc/mysql/conf.d/my.cnf
ADD supervisord-apache2.conf /etc/supervisor/conf.d/supervisord-apache2.conf
ADD supervisord-mysqld.conf /etc/supervisor/conf.d/supervisord-mysqld.conf

# Remove pre-installed database
RUN rm -rf /var/lib/mysql/*

# config to enable .htaccess
ADD apache_default /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

# Add MySQL utils
ADD create_mysql_admin_user.sh /create_mysql_admin_user.sh
RUN chmod 755 /*.sh

# Configure /app folder with sample app
RUN svn co http://svn.resourcespace.org/svn/rs/trunk /app
RUN mkdir -p /app/filestore && rm -fr /var/www/html && ln -s /app /var/www/html
RUN chmod 777 /app/filestore && chmod 777 /app/include

#Environment variables to configure php
ENV PHP_UPLOAD_MAX_FILESIZE 500M
ENV PHP_POST_MAX_SIZE 500M
ENV PHP_MEMORY_LIMIT 256M

# Add volumes for MySQL 
VOLUME  ["/etc/mysql", "/var/lib/mysql", "/app/filestore" ]

EXPOSE 80 3306
CMD ["/run.sh"]
