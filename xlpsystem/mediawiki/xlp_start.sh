#!/bin/sh

# Add open-id plugin
# https://www.mediawiki.org/wiki/Extension:OpenID
php /var/www/html/maintenance/update.php --quick

apachectl -e info -D FOREGROUND