<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use App\Phansible\RoleWithDependencies;

class Composer implements Role, RoleWithDependencies
{
    public function getName(): string
    {
        return 'Composer';
    }

    public function getSlug(): string
    {
        return 'composer';
    }

    public function getRole(): string
    {
        return 'composer';
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
