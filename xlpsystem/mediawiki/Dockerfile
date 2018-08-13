FROM bitnami/mediawiki:latest

COPY data.tar /tmp/
COPY replace_data.sh /tmp/

WORKDIR /tmp
CMD ["/bin/bash", "-c", "./replace_data.sh"]

EXPOSE 80 443
