<?php

namespace Phansible\Roles;

use Phansible\Role;

class Hhvm implements Role
{
    public function getName(): string
    {
        return 'HHVM';
    }

    public function getSlug(): string
    {
        return 'hhvm';
    }

    public function getRole(): string
    {
        return 'hhvm';
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
            'host'    => '127.0.0.1',
            'port'    => 9000,
        ];
    }
}
