# Prerequisite
## Install docker

Docker should be installed and running.

```bash
$ docker -v
Docker version 18.09.0, build 4d60db4

$ docker-compose -v
docker-compose version 1.23.2, build 1110ad01
```

## Docker login
Since docker images were uploaded to DaoCloud, we need login to DaoCloud before pull docker images.(use the account below)

```
$docker login daocloud.io -u 'bobyuxinyang' -p '3NzWxp[hKATfv'
WARNING! Using --password via the CLI is insecure. Use --password-stdin.
Login Succeeded
```

## File Sharing whitelist (mac)
If you are using Mac, `/data` directory(or any other) need to be added to the white list in order to have full access permission.
Check https://docs.docker.com/docker-for-mac/

## Get Started

### Clone this Repo

Clone this repo and goto `/xlpsystem` folder.
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


### Retore data (from initialization files)

Now we can download a initialization data file and restore to the system, so that we can use some basic configurations and init data.

Download a backup file from `https://github.com/benkoo/TensorCloud/blob/master/xlpsystem/backups/xlpsystem_empty_20190206.zip`
Then let all service down, and cp those file to `/data/xlpsystem` and up all services again

```bash
($cd ./TensorCloud/xlpsystem & wget https://github.com/benkoo/TensorCloud/blob/master/xlpsystem/backups/xlpsystem_empty_20190206.zip)
$ ./down

$ unzip xlpsystem_empty_20190206.zip

$ cp -R ./xlpsystem /data/xlpsystem

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

* http://locahost:801 Mediawiki
* http://locahost:802 Matomo
* http://locahost:803 Wordpress
* http://locahost:5601 Kibana


### Backup data
Copy all data file under `/data/xlpsystem` for backup

