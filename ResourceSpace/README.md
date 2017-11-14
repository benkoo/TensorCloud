ResourceSpace
=============

Docker image for ResourceSpace based on LAMP Docker image from tutum https://github.com/tutumcloud/lamp

Usage
-----

To create image

	docker build mstein/resourcespace .

Running
-------

To run

	docker run -d --restart=always --name resource -p 80:80 -p 3306:3306 \
	-v /data/resourcespace/mysql:/var/lib/mysql -v /data/resourcespace/filestore:/app/filestore mstein/resourcespace

Access 

Connecting to the bundled MySQL server from outside the container
-----------------------------------------------------------------

The first time that you run your container, a new user `admin` with all privileges
will be created in MySQL with a random password. To get the password, check the logs
of the container by running:

	docker logs $CONTAINER_ID

You will see an output like the following:

	========================================================================
	You can now connect to this MySQL Server using:

	    mysql -uadmin -p47nnf4FweaKu -h<host> -P<port>

	Please remember to change the above password as soon as possible!
	MySQL user 'root' has no password but only allows local connections
	========================================================================

In this case, `47nnf4FweaKu` is the password allocated to the `admin` user.

You can then connect to MySQL:

	 mysql -uadmin -p47nnf4FweaKu

Remember that the `root` user does not allow connections from outside the container -
you should use this `admin` user instead!
