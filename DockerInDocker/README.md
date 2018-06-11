Docker in Docker 
## 1.Wordpress
### 1.0 Wget
```
wget http://118.190.96.120/saved_tensor-cloud-dind_mariadb_wordpress_basic.tar.gz
```
### 1.1 Docker load
```
docker load < saved_tensor-cloud-dind_mariadb_wordpress_basic.tar.gz 
```
### 1.2 Docker run
```
docker run --name tensor-cloud-dind-mariadb-wordpress -e DOCKER_DAEMON_ARGS="-D" --privileged -d -p 4444:4444 -e PORT=4444 -e DOCKER_DAEMON_ARGS="-D" smartkit/tensor-cloud-dind:mariadb_wordpress
```
### 1.3 Docker exec in Dind
```
docker exec -it  tensor-cloud-dind-mariadb-wordpress  bash /TensorCloud/DockerInDocker/mariadb_wordpress_4445.sh
```
## 2.Mediawiki
### 2.0 Wget
```
wget http://118.190.96.120/saved_tensor-cloud-dind_mariadb_mediawiki_basic.tar.gz
```
### 2.1 Docker load

```
docker load < saved_tensor-cloud-dind_mariadb_mediawiki_basic.tar.gz
```
### 2.2 Docker run

```
docker run --rm --name tensor-cloud-dind-mariadb-mediawiki -e DOCKER_DAEMON_ARGS="-D" --privileged -d -p 4444:4444 -e PORT=4444 smartkit/tensor-cloud-dind:mariadb_mediawiki
```

#### 2.3 Docker exec 
```
docker exec -it  tensor-cloud-dind-mariadb-mediawiki  bash /TensorCloud/DockerInDocker/mariadb_mediawiki_4444.sh
```

## References

https://github.com/jpetazzo/dind

https://blog.giantswarm.io/moving-docker-container-images-around/

https://www.cyberciti.biz/faq/linux-port-redirection-with-iptables/


