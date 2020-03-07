<?php

namespace App\Phansible\Provider;

use App\Phansible\Roles\Blackfire;
use App\Phansible\RolesManager;
use App\Phansible\Roles\Apache;
use App\Phansible\Roles\Beanstalkd;
use App\Phansible\Roles\Composer;
use App\Phansible\Roles\ElasticSearch;
use App\Phansible\Roles\Hhvm;
use App\Phansible\Roles\Mariadb;
use App\Phansible\Roles\Mongodb;
use App\Phansible\Roles\Mysql;
use App\Phansible\Roles\Nginx;
use App\Phansible\Roles\Pgsql;
use App\Phansible\Roles\Php;
use App\Phansible\Roles\Rabbitmq;
use App\Phansible\Roles\Redis;
use App\Phansible\Roles\Server;
use App\Phansible\Roles\Solr;
use App\Phansible\Roles\Sqlite;
use App\Phansible\Roles\VagrantLocal;
use App\Phansible\Roles\Xdebug;
use App\Phansible\Roles\Zookeeper;

class RolesProviderStaticFactory
{
    /**
     * {@inheritdoc}
     */
    public static function create(): RolesManager
    {
        $roleManager = new RolesManager();
        // Server settings
        $roleManager->register(new Server());

        // Deploy roles
        $roleManager->register(new VagrantLocal());

        // Webservers
        $roleManager->register(new Apache());
        $roleManager->register(new Nginx());

        // Languages
        $roleManager->register(new Hhvm());

        // Databases
        $roleManager->register(new Mysql());
        $roleManager->register(new Mariadb());
        $roleManager->register(new Pgsql());
        $roleManager->register(new Mongodb());
        $roleManager->register(new Sqlite());
        $roleManager->register(new Redis());

        //Workers
        $roleManager->register(new Rabbitmq());
        $roleManager->register(new Beanstalkd());

        // Only if Solr cloud mode is enabled
        $roleManager->register(new Zookeeper());

        // Search Engines
        $roleManager->register(new Solr());
        $roleManager->register(new ElasticSearch());

        // PHP roles should always be last! this way we can detect other
        // roles and check if we need to add extra packages
        $roleManager->register(new Php());
        $roleManager->register(new Xdebug());
        $roleManager->register(new Composer());
        $roleManager->register(new Blackfire());

        return $roleManager;
    }
}
