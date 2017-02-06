<?php

namespace Phansible\Roles;

use Phansible\Role;

class Redis implements Role
{
    public function getName()
    {
        return 'Redis';
    }

    public function getSlug()
    {
        return 'redis';
    }

    public function getRole()
    {
        return 'redis';
    }

    public function getInitialValues()
    {
        return [
            'install'   => 0,
            'conf_path' => "/etc/redis",
            'db_path'   => "/var/lib/redis",
            'pid_path'  => "/var/run/redis",
            'port'      => 6379,
        ];
    }
}
