<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Redis extends BaseRole
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
