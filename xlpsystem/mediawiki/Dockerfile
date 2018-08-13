FROM bitnami/mediawiki:latest

# Replace bitnami data
COPY mediawiki_src /tmp/mediawiki_src
COPY replace_data.sh /tmp/
COPY xlp_start.sh /tmp/

WORKDIR /tmp
RUN ["/bin/bash", "-c", "./replace_data.sh"]

EXPOSE 80 443

CMD ["/bin/sh", "-c", "./xlp_start.sh"]
