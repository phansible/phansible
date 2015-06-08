<?php

namespace Phansible\Roles;

use Phansible\Role;

class Zookeeper implements Role
{
    public function getName()
    {
        return 'Zookeeper';
    }

    public function getSlug()
    {
        return 'zookeeper';
    }

    public function getRole()
    {
        return 'zookeeper';
    }

    public function getInitialValues()
    {
        return [
            'install' => 1,
            'version' => '3.4.6',
            'port'    => '2181'
        ];
    }
}
