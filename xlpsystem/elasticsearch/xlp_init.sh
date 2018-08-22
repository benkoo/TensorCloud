#!/bin/sh

# make /xlp_data
mkdir /xlp_data

# move xlp_dev to /
mv /tmp/xlp_dev /

# link xlp_dev/ik plugin
cp -r /xlp_dev/ik /usr/share/elasticsearch/plugins/ik
chown elasticsearch:elasticsearch /usr/share/elasticsearch/plugins/ik
