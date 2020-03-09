<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Redis
 * @package App\Phansible\Roles
 */
class Redis implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Redis';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'redis';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'redis';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'port'    => 6379,
        ];
    }
}
