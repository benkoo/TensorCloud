# Welcome

Welcome to TensorCloud! This project is to allow everyone to own and operate their digital assets using container technologies. The development goal is to separate assets into three functional assets:
1. Content Data Asset,
2. Software Data Asset
3. Configuration Data Asset.

# Why do we separate data this way?
Due to the varying cycle types of these different kinds of data assets, this data separation is to reduce the data payload for each kind of assets. It allows one to incrementally back-up and restore Content Data Asset independent from the other two kinds of digital asset. This organization also requires a set of accompanying tools to expedite and simplify the backup and restore processes. This will provide a mechanism to ensure better Qualities of Services (QoS), and data security properties. 

Any persons or organizations are all welcome to contribute to this project, please send pull request to us, whenever you feel that new ideas or features should be added.

## Mariadb

Website: https://mariadb.org/


## Mediawiki

Website: https://www.mediawiki.org/wiki/MediaWiki


### Mariadb+Mediawiki features



### How to run it?

```
docker-compose -f Mediawiki/mariadb_mediawiki.yml up 
```

#### Docker in Docker

```
docker run --privileged -p 80:80 -e PORT=80 smartkit/tensor-cloud-dind:mariadb_mediawiki
```

## Wordpress

Website: https://wordpress.org/


### Mariadb+Wordpress features



### How to run it?

```
docker-compose -f WordPress/mariadb_wordpress.yml up 
```
#### Docker in Docker

```
docker run --privileged -d -p 80:80 -e PORT=80 smartkit/tensor-cloud-dind:mariadb_wordpress
```

## Piwik

Website: https://matomo.org/

### Mariadb+Mediawiki+Wordpress+Piwik features



### How to run it?

```
docker-compose -f Wordpress/docker-compose.yml -f mediawiki.yml -f piwik.yml -f phabricator.yml up
```

And more, http://toyhouse.cc:81/index.php/Get_Started_with_Remix

Sincerely,

Toyhouse Team
