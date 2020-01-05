
## Installation/Deployment

- go to the folder where the Dockerfile is and launch this command

```shell
$ docker build -t conserto_chall .
```

- The image should be created without problem. However, when you launch the image you need to restart MySQL because of some "bug" not fixed for now

```shell
$ docker run -p 80:80 -td conserto_chall

$ docker ps
CONTAINER ID        IMAGE               COMMAND                  CREATED             STATUS              PORTS                                        NAMES
a13a00c28de5        conserto_chall      "apache2ctl -D FOREG…"   7 minutes ago       Up 7 minutes        0.0.0.0:80->80/tcp, 0.0.0.0:3306->3306/tcp   **laughing_cray**

$ docker exec -ti **laughing_cray** bash

root@a13a00c28de5:/# mysql -u root
ERROR 2002 (HY000): Can't connect to local MySQL server through socket '/var/run/mysqld/mysqld.sock' (2)
root@a13a00c28de5:/# service mysql restart
 * Stopping MySQL database server mysqld                                        [ OK ]
 * Starting MySQL database server mysqld No directory, logging in with HOME=/   [ OK ]

(Press Ctrl+P and Ctrl+Q to exit docker image without killing it)
```