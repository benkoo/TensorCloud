#!/bin/sh
if [ ! -d /data/xlpsystem/phabricator/ ]; then
    sudo mkdir -p /data/xlpsystem/phabricator/data/mysql
    sudo mkdir -p /data/xlpsystem/phabricator/config/mysql
    sudo mkdir -p /data/xlpsystem/phabricator/repos
    sudo mkdir -p /data/xlpsystem/phabricator/extensions
    sudo cp my.cnf /data/xlpsystem/phabricator/config/mysql
fi