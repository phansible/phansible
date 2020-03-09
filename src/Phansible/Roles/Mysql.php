<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Mysql
 * @package App\Phansible\Roles
 */
class Mysql implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'MySQL';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'mysql';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'mysql';
    }

    /**
     * @return array
     */
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
