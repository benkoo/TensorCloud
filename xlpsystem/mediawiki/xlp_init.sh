#!/bin/sh

# make /xlp_dev
mkdir /xlp_data

# add toyhouse logo
mv /tmp/xlp_dev /

<<<<<<< HEAD
# add links
=======
# add dev links
>>>>>>> origin/feature-xlpsystem
rm -rf /var/www/html/extensions
ln -s /xlp_dev/extensions /var/www/html/extensions

rm -rf /var/www/html/skins
ln -s /xlp_dev/skins /var/www/html/skins

# add toyhouse.png(logo)
ln -s /xlp_dev/toyhouse.png /var/www/html/resources/assets/toyhouse.png

<<<<<<< HEAD
# add data links
rm -rf /var/www/html/LocalSettings.php
ln -s /xlp_data/LocalSettings.php /var/www/html/LocalSettings.php
=======
# add php.ini place
rm -rf /usr/local/etc/php
ln -s /xlp_dev/php /usr/local/etc/php

# add Piwik tracking code
ln -s /xlp_data/piwik.js /var/www/html/piwik.js

# add data links
rm -rf /var/www/html/LocalSettings.php
ln -s /xlp_data/LocalSettings.php /var/www/html/LocalSettings.php

rm -rf /var/www/html/images
ln -s /xlp_data/images /var/www/html/images
>>>>>>> origin/feature-xlpsystem
