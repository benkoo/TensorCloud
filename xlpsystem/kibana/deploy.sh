#!/bin/sh

daoUsername='bobyuxinyang'
daoPassword='3NzWxp[hKATfv'

imageName='xlp_kibana'

date="$(date +%Y%m%d%H%M%S)"
image='daocloud.io/weimar/'${imageName}':'${date}

docker login daocloud.io -p ${daoPassword} -u ${daoUsername}

docker build . -t ${image}

docker push ${image}
