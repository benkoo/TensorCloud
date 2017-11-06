#!/bin/bash

service postgresql start
sudo -u postgres createuser root
sudo -u postgres createdb -E UNICODE -O root mediagoblin --template=template0
./bin/gmg dbupdate
./bin/gmg adduser --username tests --password tests --email tests@example.com
./lazyserver.sh -b 0.0.0.0:6543
