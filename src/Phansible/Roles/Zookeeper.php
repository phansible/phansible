<?php

namespace Phansible\Roles;

use Phansible\Role;

class Zookeeper implements Role
{
    public function getName(): string
    {
        return 'Zookeeper';
    }

    public function getSlug(): string
    {
        return 'zookeeper';
    }

    public function getRole(): string
    {
        return 'zookeeper';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 1,
            'version' => '3.4.6',
            'port'    => '2181',
        ];
    }
}
