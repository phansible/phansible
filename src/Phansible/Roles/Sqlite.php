<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Sqlite
 * @package App\Phansible\Roles
 */
class Sqlite implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'SQLite';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'sqlite';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'sqlite';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
        ];
    }
}
