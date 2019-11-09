<?php

namespace Phansible\Roles;

use Phansible\Role;

class Server implements Role
{
    public function getName(): string
    {
        return 'Server';
    }

    public function getSlug(): string
    {
        return 'server';
    }

    public function getRole(): string
    {
        return 'server';
    }

    public function getInitialValues(): array
    {
        return [
            'install'  => 1,
            'timezone' => 'UTC',
            'locale'   => 'en_US.UTF-8',
        ];
    }
}
