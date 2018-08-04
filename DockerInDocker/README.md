# Docker in Docker 

One of the core fundamentals of the Docker In Docker project is standardized structure. If you just want to launch one of the pre-made containers, or load a dataset given to you, just follow the instructions below. 

However, If you want to customize or incorporate your own setup for Docker In Docker, or contribute to this project you will need to learn a few of the key structural aspects of the D-in-D system. 

    1. The structure is typically like this: 1 Outer Container with 3 Inner Containers running.
    ```
    ___________________________________________
    |             |              | Volumerize |
    | Software    | Database     | (backup    |
    | (ex: Piwik) | (ex: MariaDB)| generator) |
    ___________________________________________
    ```


* If You Do Not Have Docker, please first install Docker *
Docker Installation Instructions: 

1.Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-16-04

2.Windows: https://docs.bitnami.com/containers/how-to/install-docker-in-windows/

3.MacOSX: https://docs.docker.com/docker-for-mac/install/

## 0.Docker Images Links

1.bitnami/mariadb:latest: http://118.190.96.120/saved_bitnami_mariadb_latest.tar.gz

2.btnami/wordpress:latest: http://118.190.96.120/saved_bitnami_wordpress_latest.tar.gz

3.bitnami/piwik:latest: http://118.190.96.120/saved_bitnami_piwik_latest.tar.gz

4.smartkit/mediawiki:locale: http://118.190.96.120/saved_smartkit_mediawiki_locale.tar.gz

5.smartkit/tensor-cloud-dind:

http://118.190.96.120/saved_tensor_cloud_dind_mariadb_wordpress_basic.tar.gz

http://118.190.96.120/saved_tensor_cloud_dind_mariadb_mediawiki_basic.tar.gz

http://118.190.96.120/saved_tensor_cloud_dind_mariadb_piwik_basic.tar.gz

http://118.190.96.120/saved_tensor_cloud_dind_mariadb_wordpress_remix.tar.gz

http://118.190.96.120/saved_tensor_cloud_dind_mariadb_wordpress_spacegambit.tar.gz

6.all docker image tags:

https://hub.docker.com/r/smartkit/tensor-cloud-dind/tags/

## 1.Wordpress

tags:basic,remix

### 1.0 Wget
```
wget http://118.190.96.120/saved_tensor_cloud_dind_mariadb_wordpress_basic.tar.gz
```
### 1.1 Docker load
```
docker load < saved_tensor_cloud_dind_mariadb_wordpress_basic.tar.gz 
```
or
```
docker pull smartkit/tensor-cloud-dind:mariadb_wordpress_basic
```
### 1.2 Docker run
```
docker run --name tensor-cloud-dind-mariadb-wordpress -e DOCKER_DAEMON_ARGS="-D" --privileged -d -p 4445:4445 -e PORT=4445  smartkit/tensor-cloud-dind:mariadb_wordpress_basic
```
### 1.3 Docker exec in Dind
```
docker exec -it  tensor-cloud-dind-mariadb-wordpress  bash /TensorCloud/DockerInDocker/mariadb_wordpress_4445.sh
```
## 2.Mediawiki

tags:basic,toyhouse

### 2.0 Wget
```
wget http://118.190.96.120/saved_tensor_cloud_dind_mariadb_mediawiki_basic.tar.gz
```
### 2.1 Docker load

```
docker load < saved_tensor_cloud_dind_mariadb_mediawiki_basic.tar.gz
```
or
```
docker pull smartkit/tensor-cloud-dind:mariadb_mediawiki_basic
```
### 2.2 Docker run

```
docker run --rm --name tensor-cloud-dind-mariadb-mediawiki -e DOCKER_DAEMON_ARGS="-D" --privileged -d -p 4444:4444 -e PORT=4444 smartkit/tensor-cloud-dind:mariadb_mediawiki_basic
```

#### 2.3 Docker exec 
```
docker exec -it  tensor-cloud-dind-mariadb-mediawiki  bash /TensorCloud/DockerInDocker/mariadb_mediawiki_4444.sh
```
## 3.Piwik

tags:basic,remix

### 3.0 Wget
```
wget http://118.190.96.120/saved_tensor_cloud_dind_mariadb_piwik_basic.tar.gz
```
### 3.1 Docker load

```
docker load < saved_tensor_cloud_dind_mariadb_piwik_basic.tar.gz
```
or
```
docker pull smartkit/tensor-cloud-dind:mariadb_piwik_basic
```
### 3.2 Docker run

```
docker run --rm --name tensor-cloud-dind-mariadb-piwik -e DOCKER_DAEMON_ARGS="-D" --privileged -d -p 4446:4446 -e PORT=4446 smartkit/tensor-cloud-dind:mariadb_piwik_basic
```

#### 3.3 Docker exec 
```
docker exec -it  tensor-cloud-dind-mariadb-piwik  bash /TensorCloud/DockerInDocker/mariadb_piwik_4446.sh
```


## Save your container?
```
docker save tensor-cloud-dind-mariadb-mediawiki | gzip > your_saved_tensor-cloud-dind_mariadb_mediawiki_modified.tar.gz
```

## 1.0 Dind volumerize backup
```
docker run -d \
    --name volumerize_backup \
    -v $PWD/piwik_data:/source/application_data_piwik:ro \
    -v $PWD/mariadb_data:/source/application_database_data_mariadb:ro \
    -v $PWD/backup_volume:/backup \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize
```

```
docker exec volumerize_backup backup
```

```
zip -r backup_volume_piwik.zip backup_volumue
```
Finally, copy out of Dind container.

## 2.0 Dind volumerize restore

Copy to inside of Dind container,

```
docker cp backup_volume_piwik.zip YourDindContainerID:/TensorCloud/DockerInDocker/
```
Unzip it,
```
apt-get install zip & unzip backup_volume_piwik.zip
```

Stop existed piwik docker service,

```
docker stop $(docker ps -aq)
```

Run up the volumerize_restore docker service,
```
  docker run -d \
   --name volumerize_restore \
   -v $PWD/piwik_data:/source/application_data_mediawiki \
   -v $PWD/mariadb_data:/source/application_database_data_mariadb \
   -v $PWD/backup_volume:/backup:ro \
   -v cache_volume:/volumerize-cache \
   -e "VOLUMERIZE_SOURCE=/source" \
   -e "VOLUMERIZE_TARGET=file:///backup" \
   blacklabelops/volumerize   
```

Execute restore task,

```
docker exec volumerize_restore restore
```

Finally, verify it

```
docker-compose -f mariadb_piwik.yml up -d
```


## References

https://github.com/jpetazzo/dind

https://blog.giantswarm.io/moving-docker-container-images-around/

https://www.cyberciti.biz/faq/linux-port-redirection-with-iptables/

ADJUST IMAGE SIZE OF DOCKER QCOW2 FILE: https://www.itsfullofstars.de/2017/12/adjust-the-image-size-of-docker/

In Ubuntu:
```
systemctl stop docker

nohup dockerd --storage-opt dm.basesize=150G &
```
