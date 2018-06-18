#!/bin/sh
##Mediawiki
cd /TensorCloud/DockerInDocker
mkdir -p mariadb_data
mkdir -p wordpress_data
chmod -R 777 mariadb_data
chmod -R 777 wordpress_data
#load docker images
docker load < saved_bitnami_mariadb_latest.tar.gz 
sleep 5
docker load < saved_bitnami_wordpress_latest.tar.gz
sleep 5
docker-compose -f mariadb_wordpress.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4445 -j REDIRECT --to-port 80

exit 0