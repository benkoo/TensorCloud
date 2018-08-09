# Docker in Docker

* If You Do Not Have Docker, please first install Docker *
Docker Installation Instructions: [Ubuntu](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-16-04) | [Windows](https://docs.bitnami.com/containers/how-to/install-docker-in-windows/) | [MacOSX](https://docs.docker.com/docker-for-mac/install/)

---

# EASY INSTALL

The *easiest* way to launch your containers is using the [automated launcher](https://github.com/sergio-rivas/TensorCloud-DinD)

---

# STANDARD INSTALL

## Conceptual Framework & Details

One of the core fundamentals of the Docker In Docker project is standardized structure. If you just want to launch one of the pre-made containers, or load a dataset given to you, just follow the instructions below.

However, If you want to customize or incorporate your own setup for Docker In Docker, or contribute to this project you will need to learn a few of the key structural aspects of the D-in-D system.

  1. The structure is typically like this: 1 Outer Container with 3 Inner Containers running.
  ```
  ===============OUTER CONTAINER==================
  /  ___________________________________________  /
  /  |  (inner 1)  |   (inner 2)  |  (inner 3) |  /
  /  |             |              | Volumerize |  /
  /  | Software    | Database     | (backups & |  /
  /  | (ex: Piwik) | (ex: MariaDB)| restore)   |  /
  /  ___________________________________________  /
  /                                               /
  ================================================
  ```
  2. When the outer container is first launched, the inner containers are not active yet. The second command in each example below is the command to launch the inner containers.
  3. All the scripts related to container interaction is in the outer container's path: <code>/TensorCloud/DockerInDocker/</code>
  4. The Software and Database containers have a volume mapped to 2 '_data'folders in: <code>/TensorCloud/DockerInDocker/</code> of the outer container, ex: <code>piwik_data</code> and <code>mariadb_data</code>.
  The volumes store all of the user and database data, including user file uploads, etc. These folders are then used by Volumerize whenever creating backups. As Volumerize saves the backups into the Outer Container, it is important to add a volume from the container to the root server.
  5. All the dind container images are available on [Docker Hub](https://hub.docker.com/u/tuitu/). The specific containers mentioned in this documentation are: [Wordpress](https://hub.docker.com/r/tuitu/dind-wordpress/), [Mediawiki](https://hub.docker.com/r/tuitu/dind-mediawiki/), [Piwik](https://hub.docker.com/r/tuitu/dind-piwik/)

## 1 Wordpress

### 1.1 Pull the Container

First, get the empty dind-container image setup from Dockerhub.
```
docker pull tuitu/dind-wordpress:latest
```

### 1.2 Activate the empty DinD container

Second, use this command to launch the container. NOTE: should change the following in line 2:
- Change <code>your_wordpress_container_name</code> to any name you want to give the container.
- Change the first port number in <code>-p 4445:4445</code> to whichever port you want to use. (ex: 80:4445, 888:4445, etc.)
```
docker run \
--name your_wordpress_container_name -p 4445:4445 \
-e DOCKER_DAEMON_ARGS="-D" -e PORT=4445 -e APP_NAME="wordpress" \
--privileged -d tuitu/dind-wordpress:latest
```

### 1.3 Activate the inner containers

Next, use the following command to activate the inner containers. (Remember to change <code>your_wordpress_container_name</code>) to the same container name from step 1.2
```
docker exec -it  your_wordpress_container_name \
bash /TensorCloud/DockerInDocker/mariadb_wordpress_4445.sh
```

## 2 Mediawiki

### 2.1 Pull the Container

First, get the empty dind-container image setup from Dockerhub.
```
docker pull tuitu/dind-mediawiki:latest
```

### 2.2 Activate the empty DinD container

Second, use this command to launch the container. NOTE: should change the following in line 2:
- Change <code>your_mediawiki_container_name</code> to any name you want to give the container.
- Change the first port number in <code>-p 4444:4444</code> to whichever port you want to use. (ex: 80:4444, 888:4444, etc.)
```
docker run \
--name your_mediawiki_container_name -p 4444:4444 \
-e DOCKER_DAEMON_ARGS="-D" -e PORT=4444 -e APP_NAME="mediawiki" \
--privileged -d tuitu/dind-mediawiki:latest
```

### 2.3 Activate the inner containers

Next, use the following command to activate the inner containers. (Remember to change <code>your_mediawiki_container_name</code>) to the same container name from step 1.2
```
docker exec -it  your_mediawiki_container_name \
bash /TensorCloud/DockerInDocker/mariadb_mediawiki_4444.sh
```

## 3 Piwik

### 3.1 Pull the Container

First, get the empty dind-container image setup from Dockerhub.
```
docker pull tuitu/dind-piwik:latest
```

### 3.2 Activate the empty DinD container

Second, use this command to launch the container. NOTE: should change the following in line 2:
- Change <code>your_piwik_container_name</code> to any name you want to give the container.
- Change the first port number in <code>-p 4446:4446</code> to whichever port you want to use. (ex: 80:4446, 888:4446, etc.)
```
docker run \
--name your_piwik_container_name -p 4446:4446 \
-e DOCKER_DAEMON_ARGS="-D" -e PORT=4446 -e APP_NAME="piwik" \
--privileged -d tuitu/dind-piwik:latest
```

### 3.3 Activate the inner containers

Next, use the following command to activate the inner containers. (Remember to change <code>your_piwik_container_name</code>) to the same container name from step 1.2
```
docker exec -it  your_piwik_container_name \
bash /TensorCloud/DockerInDocker/mariadb_piwik_4446.sh
```

---

## Volumerize Backup

### 1. Launch the Backup-Software Container

NOTE:  Must change "SOFTWARE" in *line 3* to <code>wordpress</code> <code>piwik</code> or <code>mediawiki</code>

```
docker run -d \
    --name volumerize_backup \
    -v $PWD/SOFTWARE_data:/source/application_data_SOFTWARE:ro \
    -v $PWD/mariadb_data:/source/application_database_data_mariadb:ro \
    -v $PWD/backup_volume:/backup \
    -v cache_volume:/volumerize-cache \
    -e "VOLUMERIZE_SOURCE=/source" \
    -e "VOLUMERIZE_TARGET=file:///backup" \
    blacklabelops/volumerize
```

### 2. Backup Your Data

```
docker exec volumerize_backup backup
```

### 3. Save the Backup as a ZIP file

```
zip -r new_backup_file_name.zip backup_volume
```

### 4. Copy out of Dind container.

Remember to change: <code>your_container_name</code>, <code>new_backup_file_name</code>, and <code>/path/to/save/file</code>
```
docker cp your_container_name:/TensorCloud/DockerInDocker/new_backup_file_name.zip /path/to/save/file
```

## Volumerize Restore

### Copy Backup INTO DinD container
Copy your backup into the Dind container. Remember to change <code>your_backup</code> & <code>your_container_name</code>

```
docker cp your_backup.zip your_container_name:/TensorCloud/DockerInDocker/
```


### Unzip Backup

First enter the DinD Container:
```
docker exec -it your_container_name bash
cd /TensorCloud/DockerInDocker/
```

Then unzip the backup:
```
unzip your_backup.zip
```


### Restore Backup

First, stop all the inner-containers.
```
docker stop $(docker ps -aq)
```


Then Launch the volumerize_restore docker service,
NOTE: Must change "SOFTWARE" in *line 3* to <code>wordpress</code> <code>piwik</code> or <code>mediawiki</code>
```
  docker run -d \
   --name volumerize_restore \
   -v $PWD/SOFTWARE_data:/source/application_data_SOFTWARE \
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

Finally, verify it.
```
docker-compose -f mariadb_piwik.yml up -d
```


## References

[Docker In Docker](https://github.com/jpetazzo/dind)

[Moving Docker Container Images Around](https://blog.giantswarm.io/moving-docker-container-images-around/)

[Linux Port Redirects via IP Tables](https://www.cyberciti.biz/faq/linux-port-redirection-with-iptables/)

[Adjust Image Size of Docker QCOW2 File](https://www.itsfullofstars.de/2017/12/adjust-the-image-size-of-docker/)

In Ubuntu:
```
systemctl stop docker

nohup dockerd --storage-opt dm.basesize=150G &
```
