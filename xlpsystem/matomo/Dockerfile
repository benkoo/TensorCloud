FROM matomo:3.5.1-apache

COPY xlp_dev /tmp/xlp_dev
COPY xlp_init.sh /tmp/
COPY xlp_start.sh /tmp/

RUN ["/bin/sh", "-c", "./xlp_init.sh"]

EXPOSE 80

CMD ["/bin/sh", "-c", "./xlp_start.sh"]
