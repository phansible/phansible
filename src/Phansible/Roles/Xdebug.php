<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleWithDependencies;

class Xdebug implements Role, RoleWithDependencies
{
    public function getName(): string
    {
        return 'XDebug';
    }

    public function getSlug(): string
    {
        return 'xdebug';
    }

    public function getRole(): string
    {
        return 'xdebug';
    }

    public function requiredRolesToBeInstalled(): array
    {
        return ['php'];
    }

    public function getInitialValues(): array
    {
        return [
            'install' => 0,
        ];
    }
}
