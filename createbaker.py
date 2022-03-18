import docker
import pathlib
import os
import shutil
import hashlib
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



website_title = 'Site do bom'
server_email = 'email@email.com'

login_name = 'administrador'
user_email = 'email@email.com' 
password = '123'
passmd5 = hashlib.md5(password.encode()).hexdigest()

os.system("\cp -f dump/db_template.sql db-seed/fresh_install.sql")
os.system("sed -i \'s/website_title_template/{}/\' db-seed/fresh_install.sql".format(website_title))
os.system("sed -i \'s/email@template.com/{}/\' db-seed/fresh_install.sql".format(server_email))
os.system("sed -i \'s/login_name_template/{}/\' db-seed/fresh_install.sql".format(login_name))
os.system("sed -i \'s/password_template/{}/\' db-seed/fresh_install.sql".format(passmd5))
os.system("sed -i \'s/user_email_template/{}/\' db-seed/fresh_install.sql".format(user_email))



docker_cli.containers.run('mysql', detach=True, name='mysql-db',
                        network='baker-installer',
                        volumes={os.path.join(dir, "mysql-vol") : {'bind' : '/var/lib/mysql' , 'mode' : 'rw'},
                                 os.path.join(dir, "db-seed") : {'bind' : '/docker-entrypoint-initdb.d', 'mode' : 'rw'}},
                        hostname='db',
                        environment=["MYSQL_ROOT_PASSWORD=passwd", "MYSQL_DATABASE=baker", "MYSQL_USER=baker", "MYSQL_PASSWORD=baker"]                  
)

