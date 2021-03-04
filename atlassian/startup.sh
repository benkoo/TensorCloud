docker volume create jiradata
docker volume create confluencedata

/usr/bin/docker-compose -f /root/docker/confluence/docker-compose.yml up -d
/usr/bin/docker-compose -f /root/docker/jira/docker-compose.yml up -d