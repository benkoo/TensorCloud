# Deploy phabricator

The deployment is based on docker-compse along with several tiny helper scripts.

## Pre-step: double check the docker-compose settings

You will need to check everything in the docker-compose.yml file before actually deploying it. Things may get better once we introduce some templating system. Key properties to check:

```yaml
...
  phabricator
  ...
    ports:
     - "10443:443"
     - "82:80"
     - "10022:22"
    volumes:
     - /phabricator/data/repos:/repos
     - /phabricator/data/extensions:/data/phabricator/phabricator/src/extensions
    environment:
     ...
     - PHABRICATOR_HOST=cd.toyhouse.cc:82
     ...
  mysql:
    restart: always
    volumes:
     - /phabricator/data/mysql:/var/lib/mysql
     - /phabricator/config/mysql:/etc/mysql
    ...
```

Make sure the ports and volumes are not introducing any conflict, the hostname (make sure to explicitly specify the port or the static resources will fail to load, if applicable). The preflight script will take care of the other stuff. Update the yaml file as needed.

## Deploy

Make sure your working directory is where the docker-compose.yml file stays.

Run the preflight script to setup the volume mount points:
```shell
./preflight.sh
```

docker-compose UP:
```
docker-compose up -d
```

## Verification

Verify the containers are running using `docker ps`:
```shell
CONTAINER ID        IMAGE                       COMMAND                  CREATED             STATUS              PORTS                                                                          NAMES
644b3b6095d3        redpointgames/phabricator   "/bin/bash /app/in..."   11 hours ago        Up 11 hours         24/tcp, 0.0.0.0:62022->22/tcp, 0.0.0.0:62080->80/tcp, 0.0.0.0:62443->443/tcp   phabricator_phabricator_1
51693537f3a3        mysql:5.7.14                "docker-entrypoint..."   11 hours ago        Up 11 hours         3306/tcp                                                                       phabricator_mysql_1
```

The initialization will take a while. Use your browser to verify the site is up and running.

## Setup backup task

Copy `auto-backup-phabricator.sh` to `/root`, and use `crontab -e` to add the content in `crontab` to enable the 24hr cron job.