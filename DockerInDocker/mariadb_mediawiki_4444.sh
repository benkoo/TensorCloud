#!/bin/sh
##Mediawiki
cd /TensorCloud/DockerInDocker
mkdir -p mariadb_data
mkdir -p mediawiki_data
chmod -R 777 mariadb_data
chmod -R 777 mediawiki_data
docker-compose -f mariadb_mediawiki.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4444 -j REDIRECT --to-port 80

exit 0