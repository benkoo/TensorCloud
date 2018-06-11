#!/bin/sh
##Mediawiki
mkdir -p TensorCloud/DockerInDocker/mariadb_data
mkdir -p TensorCloud/DockerInDocker/mediawiki_data
chmod -R 777 TensorCloud/DockerInDocker/mariadb_data
chmod -R 777 TensorCloud/DockerInDocker/mediawiki_data
cd /TensorCloud/DockerInDocker
docker-compose -f mariadb_mediawiki.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4444 -j REDIRECT --to-port 80
