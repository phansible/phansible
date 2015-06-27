<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Pgsql extends BaseRole
{
    public function getName()
    {
        return 'PostgreSQL';
    }

    public function getSlug()
    {
        return 'postgresql';
    }

    public function getRole()
    {
        return 'postgresql';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'root_password' => 123,
            'databases' => [
                'name' => 'dbname',
                'user' => 'name',
                'password' => 123,
            ]
        ];
    }
}
