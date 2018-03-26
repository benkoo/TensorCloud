#!/bin/bash -e

NUM_INSTANCES=2
MAXWAIT=600 # 10 minutes

# Check for proxy.conf override

if [ -f /deploy/proxy.conf ]; then
    cp /deploy/proxy.conf /etc/apache2/sites-available/proxy.conf
fi

# Wait for nuxeo instances to be up

time1=$(date +"%s")
# Wait nuxeo nodes
IFS=',' read -r -a NODES <<< "$NUXEO_NODES"
for NODE in "${NODES[@]}"
do
    until [ "$(curl -m 5 -s http://$NODE:8080/nuxeo/runningstatus?info=started)" == "true" ]; do
        sleep 10
    done    
done

printf "Nuxeo nodes (%s) are available, starting Apache.\n" "$NUXEO_NODES"

# Start Apache

mkdir -p /logs
chmod 0777 /logs
umask 0000
mkdir -p /logs/apache
chown www-data:www-data /logs/apache

mkdir -p $APACHE_LOG_DIR $APACHE_RUN_DIR $APACHE_LOCK_DIR
chown $APACHE_RUN_USER:$APACHE_RUN_GROUP $APACHE_LOG_DIR $APACHE_RUN_DIR $APACHE_LOCK_DIR

/usr/sbin/apache2 -D FOREGROUND
