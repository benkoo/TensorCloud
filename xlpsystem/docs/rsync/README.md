# 使用rsync从toyhouse.cc同步数据

## 步骤

1. 在本地服务器创建 toyhouse.cc 的镜像

2. 打开 rsyncd.passwd.conf ，将rsync同步密码写入，将文件改名为 rsyncd.passwd

3. 确保 rsync.passwd 权限为 600

```
chmod 600 ./rsync.passwd
```

4. 打开 sync.sh 检查如下参数

* local_path: 本地存放数据文件的路径
* remote_host: 远程服务器，当前配置为 root@toyhouse.cc
* remote_name: 远程rsync名称，当前配置为 toyhousecc
* password_file: 密码文件路径

5. 运行 sync.sh 开始同步

```
./sync.sh
```
