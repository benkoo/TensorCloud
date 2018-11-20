<<<<<<< HEAD
FROM index.docker.io/library/wordpress:4.9.7-php7.1-apache
EXPOSE 80
=======
FROM wordpress:4.9.8-php7.1-apache

COPY xlp_dev /tmp/xlp_dev
COPY xlp_init.sh /tmp/
COPY xlp_start.sh /tmp/

RUN ["/bin/sh", "-c", "/tmp/xlp_init.sh"]

EXPOSE 80

CMD ["/bin/sh", "-c", "/tmp/xlp_start.sh"]
>>>>>>> origin/feature-xlpsystem
