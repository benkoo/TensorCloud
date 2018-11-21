echo start...

local_path='/data/xlpsystem'

remote_host='root@toyhouse.cc'
remote_name='toyhousecc'

password_file='./rsyncd.passwd'

rsync -vazu --progress --delete ${remote_host}::${remote_name} ${local_path} --password-file=${password_file}