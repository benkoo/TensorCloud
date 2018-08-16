#!/bin/sh

# make /xlp_dev
mkdir /xlp_data

# move xlp_dev to /
mv /tmp/xlp_dev /

# link xlp_dev/wordpress wordpres_src
rm -rf /usr/src/wordpress
ln -s /xlp_dev/wordpress /usr/src/wordpress
cp -R /xlp_dev/wordpress /var/www/html/wordpress

# link xlp_data/uploads
# rm -rf /var/www/html/wp-content/uploads
# ln -s /xlp_data/uploads /var/www/html/wp-content/uploads
