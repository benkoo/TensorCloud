#!/bin/sh

# auto backup
date="$(date +%Y%m%d%H%M%S)"

# too slow, disable now
tar cvfz /var/www/backups/xlpsystem_cd_toyhouse_cc_80_${date}.tar.gz /data/xlpsystem_cd_toyhouse_cc_80

# remove old files and cp new onw
rm -rf /data/xlpsystem_cd_toyhouse_cc_50000
cp -R /data/xlpsystem_cd_toyhouse_cc_80 /data/xlpsystem_cd_toyhouse_cc_50000

# kill and restart docker containers
docker ps | grep cd_toyhouse_cc_50000 | awk  '{print "docker restart " $1}' | sh
