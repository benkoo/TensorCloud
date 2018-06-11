#!/bin/sh
##Wordpress
#cd ~/TensorCloud
docker-compose -f TensorCloud/Volumerize/mariadb_mediawiki.yml up -d
#port forwarding
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport 4444 -j REDIRECT --to-port 80
