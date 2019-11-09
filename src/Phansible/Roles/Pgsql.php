<?php

namespace Phansible\Roles;

use Phansible\Role;

class Pgsql implements Role
{
    public function getName(): string
    {
        return 'PostgreSQL';
    }

    public function getSlug(): string
    {
        return 'pgsql';
    }

    public function getRole(): string
    {
        return 'pgsql';
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
