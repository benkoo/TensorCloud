Docker in Docker 
## 1.Wordpress
### 1.1Docker run

```
docker run --name tensor-cloud-dind-mariadb-wordpress --privileged -d -p 4444:4444 -e PORT=4444 smartkit/tensor-cloud-dind:mariadb_wordpress
```
### 1.2Docker exec in Dind

```
docker exec -it  tensor-cloud-dind-mariadb-wordpress /bin/bash
```

### 1.3Port forwarding in Dind
```
iptables -t nat -A PREROUTING -i eth0 -p tcp --dport $srcPortNumber -j REDIRECT --to-port $dstPortNumber
```

## 2.Mediawiki
### 

## References

https://github.com/jpetazzo/dind


