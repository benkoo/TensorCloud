#!/bin/sh
##Mediawiki
mkdir -p TensorCloud/DockerInDocker/mariadb_data
mkdir -p TensorCloud/DockerInDocker/wordpress_data
chmod -R 777 TensorCloud/DockerInDocker/mariadb_data
chmod -R 777 TensorCloud/DockerInDocker/wordpress_data
cd /TensorCloud/DockerInDocker
docker-compose -f mariadb_wordpress.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4445 -j REDIRECT --to-port 80
