#!/usr/bin/env bash

rm -rf src/Phansible/Resources/ansible/roles/apache
rm -rf src/Phansible/Resources/ansible/roles/beanstalkd
rm -rf src/Phansible/Resources/ansible/roles/blackfire
rm -rf src/Phansible/Resources/ansible/roles/composer
rm -rf src/Phansible/Resources/ansible/roles/elasticsearch
rm -rf src/Phansible/Resources/ansible/roles/mariadb
rm -rf src/Phansible/Resources/ansible/roles/mongodb
rm -rf src/Phansible/Resources/ansible/roles/mysql
rm -rf src/Phansible/Resources/ansible/roles/nginx
rm -rf src/Phansible/Resources/ansible/roles/pgsql
rm -rf src/Phansible/Resources/ansible/roles/php
rm -rf src/Phansible/Resources/ansible/roles/rabbitmq
rm -rf src/Phansible/Resources/ansible/roles/redis
rm -rf src/Phansible/Resources/ansible/roles/server
rm -rf src/Phansible/Resources/ansible/roles/solr
rm -rf src/Phansible/Resources/ansible/roles/sqlite
rm -rf src/Phansible/Resources/ansible/roles/vagrant_local
rm -rf src/Phansible/Resources/ansible/roles/xdebug
rm -rf src/Phansible/Resources/ansible/roles/zookeeper

git clone https://github.com/phansible/role-apache.git src/Phansible/Resources/ansible/roles/apache
git clone https://github.com/phansible/role-beanstalkd.git src/Phansible/Resources/ansible/roles/beanstalkd
git clone https://github.com/phansible/role-blackfire.git src/Phansible/Resources/ansible/roles/blackfire
git clone https://github.com/phansible/role-composer.git src/Phansible/Resources/ansible/roles/composer
git clone https://github.com/phansible/role-elasticsearch.git src/Phansible/Resources/ansible/roles/elasticsearch
git clone https://github.com/phansible/role-mariadb.git src/Phansible/Resources/ansible/roles/mariadb
git clone https://github.com/phansible/role-mongodb.git src/Phansible/Resources/ansible/roles/mongodb
git clone https://github.com/phansible/role-mysql.git src/Phansible/Resources/ansible/roles/mysql
git clone https://github.com/phansible/role-nginx.git src/Phansible/Resources/ansible/roles/nginx
git clone https://github.com/phansible/role-pgsql.git src/Phansible/Resources/ansible/roles/pgsql
git clone https://github.com/phansible/role-php.git src/Phansible/Resources/ansible/roles/php
git clone https://github.com/phansible/role-rabbitmq.git src/Phansible/Resources/ansible/roles/rabbitmq
git clone https://github.com/phansible/role-redis.git src/Phansible/Resources/ansible/roles/redis
git clone https://github.com/phansible/role-server.git src/Phansible/Resources/ansible/roles/server
git clone https://github.com/phansible/role-solr.git src/Phansible/Resources/ansible/roles/solr
git clone https://github.com/phansible/role-sqlite.git src/Phansible/Resources/ansible/roles/sqlite
git clone https://github.com/phansible/role-vagrant_local.git src/Phansible/Resources/ansible/roles/vagrant_local
git clone https://github.com/phansible/role-xdebug.git src/Phansible/Resources/ansible/roles/xdebug
git clone https://github.com/phansible/role-zookeeper.git src/Phansible/Resources/ansible/roles/zookeeper
