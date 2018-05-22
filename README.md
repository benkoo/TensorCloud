# Welcome

Welcome to TensorCloud! This is the default page we've installed for your convenience. Go ahead and edit it.

## Mariadb

Website: https://mariadb.org/


## Mediawiki

Website: https://www.mediawiki.org/wiki/MediaWiki


### Mariadb+Mediawiki features



### How to run it?

```
docker-compose -f mariadb_mediawiki.yml up 
```

#### Docker in Docker

```
docker run --privileged -p 80:80 -p 3306:3306 smartkit/tensor-cloud-dind:mariadb_mediawiki
```

## Piwik


Website: https://matomo.org/


### Mariadb+Mediawiki+Piwik features



### How to run it?

```
docker-compose -f mariadb_mediawiki_piwik.yml up 
```

### Mariadb+Mediawiki+Wordpress+Piwik features



### How to run it?

```
docker-compose -f Wordpress/docker-compose.yml -f mediawiki.yml -f piwik.yml -f phabricator.yml up
```

And more, http://toyhouse.cc/wiki/index.php/Get_Started_with_Remix#Using_Remix
