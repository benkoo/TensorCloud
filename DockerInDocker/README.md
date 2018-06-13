Docker in Docker 

Install Docker: 

1.Ubuntu: https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-16-04

2.Windows: https://docs.bitnami.com/containers/how-to/install-docker-in-windows/

3.MacOSX: https://docs.docker.com/docker-for-mac/install/

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

## References

https://github.com/jpetazzo/dind

https://blog.giantswarm.io/moving-docker-container-images-around/

https://www.cyberciti.biz/faq/linux-port-redirection-with-iptables/


