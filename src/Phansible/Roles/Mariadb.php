<?php

namespace Phansible\Roles;

use Phansible\Role;

class Mariadb implements Role
{
    public function getName(): string
    {
        return 'MariaDb';
    }

    public function getSlug(): string
    {
        return 'mariadb';
    }

    public function getRole(): string
    {
        return 'mariadb';
    }

    public function getInitialValues(): array
    {
        return [
            'install'       => 0,
            'root_password' => 123,
            'databases'     => [
                'name'     => 'dbname',
                'user'     => 'name',
                'password' => 123,
            ],
        ];
    }
}
