# Prerequisite
## Install docker

Docker should be installed and running.

```bash
$ docker -v
Docker version 18.09.0, build 4d60db4

$ docker-compose -v
docker-compose version 1.23.2, build 1110ad01
```

## File Sharing whitelist (mac)
If you are using Mac, `/data` directory(or any other) need to be created manually under root directory and added to the white list in order to have full access permission. One can use the GUI feature of Docker to do the following:

Mac OS 10.14.2 & Docker Version 2.0.0.2 (30215):Menu->Preferences->File Sharing

## Get Started

### Clone this Repo

Clone this repo, then goto `/xlpsystem` folder.
```
$ git clone git@github.com:benkoo/TensorCloud.git

$ cd ./TensorCloud/xlpsystem
```

### Check xlpsystem_config.yml config file

Before lift up services, we could open `xlpsystem_config.yml` and check those configs.

The config may be like below:

```yml
version: '2'
services:
  mariadb:
    image: mariadb:10.3
    restart: always
    environment:
    - MYSQL_ROOT_PASSWORD=W2qgpsLtQt
    volumes:
    - /data/xlpsystem/mariadb/:/var/lib/mysql
  mediawiki:
    image: daocloud.io/weimar/xlp_mediawiki:20180827140844
    restart: always
    ports:
    - 801:80
    volumes:
    - /data/xlpsystem/mediawiki:/xlp_data
    - /data/xlpsystem/mediawiki_dev:/xlp_dev
    depends_on:
    - mariadb
    - matomo
    - elasticsearch
  wordpress:
    image: daocloud.io/weimar/xlp_wordpress:20180820185725
    restart: always
    environment:
    - WORDPRESS_DB_HOST=mariadb
    - WORDPRESS_DB_PASSWORD=W2qgpsLtQt
    ports:
    - 803:80
    volumes:
    - /data/xlpsystem/wordpress:/var/www/html
    depends_on:
    - mariadb
    - matomo
  matomo:
    image: daocloud.io/weimar/xlp_matomo:20180820163542
    restart: always
    ports:
    - 802:80
    volumes:
    - /data/xlpsystem/matomo:/var/www/html
    depends_on:
    - mariadb
  elasticsearch:
    image: daocloud.io/weimar/xlp_elasticsearch:20180822142218
    ports:
    - 9200:9200
    - 9300:9300
    volumes:
    - /data/xlpsystem/elasticsearch:/usr/share/elasticsearch/data
    environment:
    - discovery.type=single-node
    - bootstrap.memory_lock=true
    - ES_JAVA_OPTS=-Xms512m -Xmx512m
    ulimits:
      memlock:
        soft: -1
        hard: -1
    mem_limit: 1g
  kibana:
    image: daocloud.io/weimar/xlp_kibana:20180821233221
    ports:
    - 5601:5601
    depends_on:
    - elasticsearch
```

Tips

* All volumes are stored at `/data/xlpsystem`
* `ports` section defines the http ports we use
* Mariadb root password is "W2qgpsLtQt"
* We can remove some services like "phabricator" or "grafana" if there's no need.

### UP!
before ./up command, you should log out your own DockerHub account (in case you created one and logged in earlier) to avoid conflict (see https://github.com/docker/hub-feedback/issues/935)
```bash
$ ./up
Creating xlpsystem_elasticsearch_1 ... done
Creating xlpsystem_mariadb_1       ... done
Creating xlpsystem_matomo_1        ... done
Creating xlpsystem_kibana_1        ... done
Creating xlpsystem_wordpress_1     ... done
Creating xlpsystem_mediawiki_1     ... done
```

After doing this, open your browser and navgate to `localhost:801`, you should see an empty mediawiki.


### Restore data (from initialization files)

Initialization data file has been uploaded to ./xlpsystem/backups in zip format (current version xlpsystem_empty_20190206.zip)

Now let all service down, and cp those file to `/data/xlpsystem` and up all services again

```bash

$ ./down

$ unzip xlpsystem_empty_20190206.zip //this could be done manually

$ cp -R ./xlpsystem /data/xlpsystem //this could be done manually

$ ./up
```

Some account info for the init data.

```
database table name: neet_wiki
database account: root / W2qgpsLtQt
mediawiki admin: xlp / W2qgpsLtQt
matomo admin: xlp / W2qgpsLtQt
wordpress admin: xlp / W2qgpsLtQt
```

and now services can be accessd by `locahost'

* http://localhost:801 Mediawiki
* http://localhost:802 Matomo
* http://localhost:803 Wordpress
* http://localhost:5601 Kibana


### Backup data
Copy all data file under `/data/xlpsystem` for backup

