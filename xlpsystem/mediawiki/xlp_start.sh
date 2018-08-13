#!/bin/sh

# Add open-id plugin
# https://www.mediawiki.org/wiki/Extension:OpenID
php /opt/bitnami/mediawiki/maintenance/update.php

/opt/bitnami/apache/bin/httpd -DFOREGROUND -f /opt/bitnami/apache/conf/httpd.conf
