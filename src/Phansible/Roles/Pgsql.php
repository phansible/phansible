<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Pgsql
 * @package App\Phansible\Roles
 */
class Pgsql implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'PostgreSQL';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'pgsql';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'pgsql';
    }

    /**
     * @return array
     */
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
