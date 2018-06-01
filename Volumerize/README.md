Docker Volume Backups Multiple Backends

## 1.Mediawiki namespace

### 0.wget mariadb_mediawiki.yml
```
curl -sSL https://raw.githubusercontent.com/benkoo/TensorCloud/master/mariadb_mediawiki.yml > mariadb_mediawiki.yml
```

### 1.start mariadb_mediawiki
```
docker-compose -f mariadb_mediawiki.yml up -d
```

### 2.0 run volumerize backup
```
    docker run -d \
    --name volumerize \
    -v mediawiki_mediawiki_data:/source/application_data_mediawiki:ro \
    -v mediawiki_mariadb_data:/source/application_database_data_mariadb:ro \
    -v mediawiki_mediawiki_data:/source/application_configuration_mediawiki:ro \
    -v backup_volume:/backup \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize
```

### 2.1 exec volumerize backup
```
 docker exec volumerize backup
```
### 3.1 stop volumerize
```
docker stop $(docker ps -a -q)
```

### 3.1.1 Remove volumerize
```
docker rm volumerize
```
### 3.2 stop volumerize
```
docker stop volumerize
```
### 4.volumerize restore
 ```
    docker run -d \
    --name volumerize \
    -v mediawiki_mediawiki_data:/source/application_data_mediawiki:ro \
    -v mediawiki_mariadb_data:/source/application_database_data_mariadb:ro \
    -v mediawiki_mediawiki_data:/source/application_configuration_mediawiki:ro \
    -v backup_volume:/backup:ro \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize
```
### 5.start mariadb_mediawiki again to verify
```
docker-compose -f mariadb_mediawiki.yml up -d
```
### 6.start volumerize again
```
docker start volumerize
```


## 2.Wordpress namespace

## 3.Piwik namespace

## References

https://github.com/blacklabelops/volumerize

http://toyhouse.cc/wiki/index.php/MediaWiki_%E7%9A%84%E5%AE%89%E8%A3%85%E3%80%81%E6%95%B0%E6%8D%AE%E5%A4%87%E4%BB%BD%E3%80%81%E6%95%B0%E6%8D%AE%E6%81%A2%E5%A4%8D

