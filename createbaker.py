import docker
import pathlib
import os
import shutil

dir = pathlib.Path().resolve()

docker_cli = docker.from_env()
# print(dir)

try:
    docker_cli.networks.get('baker-installer')
except:
    docker_cli.networks.create('baker-installer')

docker_cli.containers.run('baker-installer' , detach=True, name="baker-installer", 
                        network='baker-installer',
                        volumes={os.path.join(dir, "workdir") : {'bind' : '/var/www/html' , 'mode' : 'rw'}},
                        ports={'80/tcp' : 8080})
shutil.copytree(os.path.join(dir, "cms-baker/2_13_0/"), os.path.join(dir, "workdir"), dirs_exist_ok=True)
os.system("chown -R 33.33 workdir/")
docker_cli.containers.get("baker-installer").exec_run("docker-php-ext-install mysqli")

docker_cli.containers.run('mysql', detach=True, name='mysql-db',
                        network='baker-installer',
                        volumes={os.path.join(dir, "mysql-vol") : {'bind' : '/var/lib/mysql' , 'mode' : 'rw'}},
                        hostname='db',
                        environment=["MYSQL_ROOT_PASSWORD=passwd", "MYSQL_DATABASE=baker", "MYSQL_USER=baker", "MYSQL_PASSWORD=baker"]                  
)

