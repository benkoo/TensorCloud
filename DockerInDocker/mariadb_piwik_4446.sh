#!/bin/sh
##Mediawiki
cd /TensorCloud/DockerInDocker
mkdir -p mariadb_data
mkdir -p piwik_data
chmod -R 777 mariadb_data
chmod -R 777 piwik_data
#load docker images
docker load < saved_bitnami_mariadb_latest.tar.gz 
sleep 5
docker load < saved_bitnami_piwik_latest.tar.gz
sleep 5
docker-compose -f mariadb_piwik.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4446 -j REDIRECT --to-port 80

exit 0