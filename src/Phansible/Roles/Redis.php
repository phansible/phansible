<?php

namespace Phansible\Roles;

use Phansible\Role;

class Redis implements Role
{
    public function getName(): string
    {
        return 'Redis';
    }

    public function getSlug(): string
    {
        return 'redis';
    }

    public function getRole(): string
    {
        return 'redis';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'port'    => 6379,
        ];
    }
}
