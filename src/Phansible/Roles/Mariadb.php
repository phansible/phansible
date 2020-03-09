<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Mariadb
 * @package App\Phansible\Roles
 */
class Mariadb implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'MariaDb';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'mariadb';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'mariadb';
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
