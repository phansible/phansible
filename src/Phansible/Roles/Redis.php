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
            'install' => 0,
            'port'    => 6379,
        ];
    }
}
