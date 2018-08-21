#!/bin/sh

# make /xlp_data
mkdir /xlp_data

# move xlp_dev to /
mv /tmp/xlp_dev /

# link xlp_dev/wordpress wordpres_src
# ln -s /xlp_dev/ik /usr/share/elasticsearch/plugin/ik