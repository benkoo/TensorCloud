#!/bin/sh
##Mediawiki,Wordpress,Piwik,Phabricator,OpenModelica,Jenkins
cd ~/TensorCloud & git pull
docker-compose -f mariadb_mediawiki.yml -f wordpress.yml -f piwik.yml -f phabricator.yml -f openmodelica-webbook.yml -f jenkins.yml -d
##ResourceSpace
~/resourcespace-8.3.1/ctlscript.sh start