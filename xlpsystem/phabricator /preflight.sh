#!/bin/sh
if [ ! -d /phabricator/ ]; then
    mkdir -p /phabricator/data/
    mkdir -p /phabricator/config/mysql
    cp my.cnf /phabricator/config/mysql/
fi