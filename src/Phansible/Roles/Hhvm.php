<?php

namespace Phansible\Roles;

use Phansible\Role;

class Hhvm implements Role
{
    public function getName()
    {
        return 'HHVM';
    }

    public function getSlug()
    {
        return 'hhvm';
    }

    public function getRole()
    {
        return 'hhvm';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'host'    => '127.0.0.1',
            'port'    => 9000,
        ];
    }
}
