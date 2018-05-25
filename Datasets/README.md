

1.Download Toyhouse.cc SQL data: http://118.190.96.120/toyhousewiki_67.sql.gz

1.1.Drop original database:
```
DROP DATABASE bitnami_mediawiki;
```
1.2.Create anew database with utf-8 charset:
```
REATE DATABASE bitnami_mediawiki DEFAULT CHARACTER SET utf8 DEFAULT COLLATE utf8_general_ci;
```

2.Download Toyhouse.cc application data: http://118.190.96.120/toyhouseWiki.tar.gz

2.1 copy images.zip to Mediawiki docker container:
```
docker cp images.zip MediawikiDockerContainerID:/opt/bitnami/mediawiki/ 
```

2.2 unzip it inside docker container:
```
unzip /opt/bitnami/mediawiki/images.zip
```

2.3 Going to run database updates for bitnami_mediawiki-wiki_,Depending on the size of your database this may take a while!

```
php maintenance/update.php
```

2.4 Rebuilding links tables -- this can take a long time. It should be safe to abort via ctrl+C if you get bored.

```
php maintenance/rebuildall.php
```
2.5 RestartMediawiki docker container in case:
```
docker restart MediawikiContainerID
```

Piwik dataset: http://118.190.96.120/bitnami_piwik_20171222.sql

## 3 data-layers for Volumerize backup and restore.

1.Database

2.Configuration

3.Application


## Reference

http://toyhouse.cc/wiki/index.php/MediaWiki_%E7%9A%84%E5%AE%89%E8%A3%85%E3%80%81%E6%95%B0%E6%8D%AE%E5%A4%87%E4%BB%BD%E3%80%81%E6%95%B0%E6%8D%AE%E6%81%A2%E5%A4%8D

http://holors.org:86/T266

https://stackoverflow.com/questions/1002258/exporting-and-importing-images-in-mediawiki

