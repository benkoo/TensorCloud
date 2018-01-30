#!/bin/sh
##Mediawiki,Wordpress,Piwik,Phabricator,OpenModelica,Jenkins
#cd ~/TensorCloud
docker-compose -f /home/toyhouse/TensorCloud/mariadb_mediawiki.yml -f /home/toyhouse/TensorCloud/wordpress.yml -f /home/toyhouse/TensorCloud/piwik.yml -f /home/toyhouse/TensorCloud/phabricator.yml -f /home/toyhouse/TensorCloud/openmodelica-webbook.yml -f /home/toyhouse/TensorCloud/jenkins.yml up -d
##ResourceSpace
/home/toyhouse/resourcespace-8.3-1/ctlscript.sh start
