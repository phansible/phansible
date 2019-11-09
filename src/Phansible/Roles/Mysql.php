<?php

namespace Phansible\Roles;

use Phansible\Role;

class Mysql implements Role
{
    public function getName(): string
    {
        return 'MySQL';
    }

    public function getSlug(): string
    {
        return 'mysql';
    }

    public function getRole(): string
    {
        return 'mysql';
    }

    public function getInitialValues(): array
    {
        return [
            'install'       => 1,
            'root_password' => 123,
            'databases'     => [
                'name'     => 'dbname',
                'user'     => 'name',
                'password' => 123,
            ],
        ];
    }
}
