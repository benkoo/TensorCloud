#!/bin/sh
##Mediawiki
cd /TensorCloud/DockerInDocker
mkdir mariadb_data
mkdir wordpress_data
chmod -R 777 mariadb_data
chmod -R 777 wordpress_data

docker-compose -f mariadb_wordpress.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4445 -j REDIRECT --to-port 80

exit 0