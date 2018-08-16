FROM wordpress:4.9.8-php7.1-apache

RUN rm -rf /usr/src/wordpress
COPY xlp_dev /usr/src/wordpress
RUN mkdir /usr/src/wordpress/wp-content/uploads && \
    chmod a+w /usr/src/wordpress/wp-content/uploads

RUN ln -s /var/www/html/wp-content /xlp_data

EXPOSE 80
