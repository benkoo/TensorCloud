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

Waiting...Mariadb_Mediawiki service up...

### 2.0 run volumerize backup
```
   docker run -d \
    --name volumerize_backup \
    -v volumerize_mediawiki_data:/source/application_data_mediawiki:ro \
    -v volumerize_mariadb_data:/source/application_database_data_mariadb:ro \
    -v $PWD/backup_volume:/backup \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize
```

### 2.1 exec volumerize backup
```
 docker exec volumerize_backup backup
```
### 2.2 stop volumerize_backup
```
docker stop volumerize_backup
```

### 2.4 Remove volumerize_backup
```
docker rm volumerize_backup
```
### 2.5 save volumerize_backup
```
tar -cvf back_volume.tar.gz back_volume
```

### 3.0 transfer back_volume.tar.gz to another machine
```
gunzip back_volume.tar.gz
```
### 3.1 repeate step 0,1 in another machine

### 4.run volumerize restore
 ```
   docker run -d \
    --name volumerize_restore \
    -v volumerize_mediawiki_data:/source/application_data_mediawiki \
    -v volumerize_mariadb_data:/source/application_database_data_mariadb \
    -v $PWD/backup_volume:/backup:ro \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize 
```
### 4.1 stop mariadb_mediawiki
```
docker-compose -f mariadb_mediawiki.yml down
```

### 4.2 exec volumerize restore

```
 docker exec volumerize_restore restore
```

### 4.3 stop volumerize_restore

```
docker stop volumerize_restore
```

### 4.4 Remove volumerize_restore

```
docker rm volumerize_restore
```

### 5.start mariadb_mediawiki again to verify

```
docker-compose -f mariadb_mediawiki.yml up -d
```

Waiting...Mariadb_Mediawiki service up and restored...

## 2.Wordpress namespace

## 3.Piwik namespace

## References

https://github.com/blacklabelops/volumerize

http://toyhouse.cc/wiki/index.php/MediaWiki_%E7%9A%84%E5%AE%89%E8%A3%85%E3%80%81%E6%95%B0%E6%8D%AE%E5%A4%87%E4%BB%BD%E3%80%81%E6%95%B0%E6%8D%AE%E6%81%A2%E5%A4%8D
