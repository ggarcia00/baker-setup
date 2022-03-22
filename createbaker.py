import pathlib
import os
import shutil
import hashlib
import argparse

dir = pathlib.Path().resolve()


parser = argparse.ArgumentParser()

# Configs relative to website
parser.add_argument("--slug", type=str)
parser.add_argument("--website-title", type=str)
parser.add_argument("--server-email", type=str)

# Configs relative to admin user
parser.add_argument("--user-email", type=str)
parser.add_argument("--user-login", type=str)
parser.add_argument("--user-password", type=str)

args = parser.parse_args()

website_title = args.website_title
server_email = args.server_email

user_email = args.user_email 
user_login = args.user_login
user_password = args.user_password


shutil.copytree(os.path.join(dir, "cms-baker/2_13_0/"), os.path.join(dir, "output", args.slug), dirs_exist_ok=True)

passmd5 = hashlib.md5(user_password.encode()).hexdigest()

os.system("\cp -f dump/db_template.sql output/sql_data/{}.sql".format(args.slug))
os.system("sed -i \'s/website_title_template/{}/\' output/sql_data/{}.sql".format(website_title, args.slug))
os.system("sed -i \'s/email@template.com/{}/\' output/sql_data/{}.sql".format(server_email, args.slug))
os.system("sed -i \'s/login_name_template/{}/\' output/sql_data/{}.sql".format(user_login, args.slug))
os.system("sed -i \'s/password_template/{}/\' output/sql_data/{}.sql".format(passmd5, args.slug))
os.system("sed -i \'s/user_email_template/{}/\' output/sql_data/{}.sql".format(user_email, args.slug))