#!/bin/sh
##Mediawiki
cd /TensorCloud/DockerInDocker
mkdir -p mariadb_data
mkdir -p piwik_data
chmod -R 777 mariadb_data
chmod -R 777 piwik_data

docker-compose -f mariadb_piwik.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4446 -j REDIRECT --to-port 80

exit 0