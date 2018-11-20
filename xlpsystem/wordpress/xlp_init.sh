#!/bin/sh

# make /xlp_data
mkdir /xlp_data

# move xlp_dev to /
mv /tmp/xlp_dev /

# link xlp_dev/wordpress wordpres_src
rm -rf /usr/src/wordpress
ln -s /xlp_dev/wordpress /usr/src/wordpress
