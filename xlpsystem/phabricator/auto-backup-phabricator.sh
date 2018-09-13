#!/bin/sh

# auto backup
date="$(date +%Y%m%d%H%M%S)"

# too slow, disable now
tar cvfz /var/www/backups/phabricator_cd_toyhouse_cc_80_${date}.tar.gz /phabricator/data/

