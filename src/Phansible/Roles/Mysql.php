<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Mysql extends BaseRole
{
    public function getName()
    {
        return 'MySQL';
    }

    public function getSlug()
    {
        return 'mysql';
    }

    public function getRole()
    {
        return 'mysql';
    }

    public function getInitialValues()
    {
        return [
            'install' => 1,
            'root_password' => 123,
            'databases' => [
                'name' => 'dbname',
                'user' => 'name',
                'password' => 123,
            ]
        ];
    }
}
