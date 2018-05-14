
```
mysqldump -S /opt/lampp/var/mysql/mysql.sock -h toyhouse.cc -u ???? -p ??????? | pv --progress --size 4096m | gzip > toyhousewiki.sql.gz
```
```
CREATE DATABASE IF NOT EXISTS remix_mediawiki DEFAULT CHARSET utf8 COLLATE utf8_general_ci;
```
```
use remix_mediawiki 
```
```
source toyhousewiki_67.sql
```

# @see

https://github.com/wikimedia/mediawiki-docker

https://www.mediawiki.org/wiki/Manual:Upgrading_MySQL

https://www.mediawiki.org/wiki/Extension:Piwik_Integration
