<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;

/**
 * Class Server
 * @package App\Phansible\Roles
 */
class Server implements Role
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Server';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'server';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'server';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [
            'install'  => 1,
            'timezone' => 'UTC',
            'locale'   => 'en_US.UTF-8',
        ];
    }
}
