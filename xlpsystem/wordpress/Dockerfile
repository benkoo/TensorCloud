FROM wordpress:4.9.8-php7.1-apache

# COPY xlp_dev /tmp/xlp_dev
COPY xlp_init.sh /tmp/

WORKDIR /tmp
RUN ["/bin/sh", "-c", "./xlp_init.sh"]
WORKDIR /var/www/html

COPY xlp_dev /var/www/html

EXPOSE 80
