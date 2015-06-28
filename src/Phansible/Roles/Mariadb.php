<?php

namespace Phansible\Roles;

use Phansible\Role;

class Mariadb implements Role
{
    public function getName()
    {
        return 'MariaDb';
    }

    public function getSlug()
    {
        return 'mariadb';
    }

    public function getRole()
    {
        return 'mariadb';
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
