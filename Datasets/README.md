

## 3 data-layers for Volumerize backup and restore.

1.Database, for example: mariadb database;

2.Application, for example: mediawiki images folder;

3.Configuration, for example: mediawiki configurations;


### Mediawiki example:

1.Download Toyhouse.cc **SQL data**: http://118.190.96.120/toyhousewiki_67.sql.gz

1.1.Docker-compose up:
```
curl -sSL https://raw.githubusercontent.com/benkoo/TensorCloud/master/Mediawiki/docker-compose.yml > docker-compose.yml
```
```
docker-compose up -d
```
1.2.Drop original database:
```
docker exec -it YourMariadbContainerID /bin/bash 
```
```
mysql -u root
```
```
show databases;
```
```
DROP DATABASE bitnami_mediawiki;
```
1.3.Find database character set and collate info:

```
SELECT SCHEMA_NAME 'database', default_character_set_name 'charset', DEFAULT_COLLATION_NAME 'collation' FROM information_schema.SCHEMATA;
```
1.4.Create anew database with same charset:
(for utf8)
```
CREATE DATABASE bitnami_mediawiki DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
```
(for latin1)
```
CREATE DATABASE bitnami_mediawiki DEFAULT CHARACTER SET latin1 DEFAULT COLLATE latin1_swedish_ci;
```
1.5.Import database:
```
use bitnami_mediawiki;
```
```
source /toyhouseWiki20180528Latin1.sql
```

2.Download Toyhouse.cc **application data**: ftp://118.190.3.169/toyhouseWiki.tar.gz

2.1 copy images.zip to Mediawiki docker container:
```
docker cp images.zip MediawikiDockerContainerID:/opt/bitnami/mediawiki/ 
```

2.2 unzip it inside docker container:
```
sudo apt-get update && sudo apt-get install unar
```
```
unar -e gb18030 /opt/bitnami/mediawiki/images.zip
```

2.3 Going to run database updates for bitnami_mediawiki-wiki_,Depending on the size of your database this may take a while!

```
php /opt/bitnami/mediawiki/maintenance/update.php
```

2.4 Rebuilding links tables -- this can take a long time. It should be safe to abort via ctrl+C if you get bored.

```
php /opt/bitnami/mediawiki/maintenance/rebuildall.php
```
2.5 RestartMediawiki docker container in case:
```
docker restart MediawikiContainerID
```
3.0.About **Configuration data**

3.1.Mediawiki LocalSettings.php 

```
# MySQL specific settings
$wgDBprefix = "";
```
```
sudo docker cp toyhouse.png WikiDockerContainerID:/opt/bitnami/mediawiki/resources/assets/wiki.png
```
3.2.Docker cp toyhouse.png to wiki docker container logo:
```
sudo docker cp toyhouse.png WikiDockerContainerID:/opt/bitnami/mediawiki/resources/assets/wiki.png
```
3.2.LocalSettings.php

Example: https://github.com/benkoo/TensorCloud/blob/master/Mediawiki/LocalSettings.php

Plugins: https://github.com/benkoo/TensorCloud/tree/master/Mediawiki/Extensions

###  Piwik example

0.1.dataset: http://118.190.96.120/bitnami_piwik_20171222.sql


## Reference

http://toyhouse.cc/wiki/index.php/MediaWiki_%E7%9A%84%E5%AE%89%E8%A3%85%E3%80%81%E6%95%B0%E6%8D%AE%E5%A4%87%E4%BB%BD%E3%80%81%E6%95%B0%E6%8D%AE%E6%81%A2%E5%A4%8D

http://holors.org:86/T266

https://stackoverflow.com/questions/1002258/exporting-and-importing-images-in-mediawiki

http://jaredmarkell.com/docker-and-locales/

https://theunarchiver.com/command-line

