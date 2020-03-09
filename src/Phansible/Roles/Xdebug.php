<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use App\Phansible\RoleWithDependencies;

/**
 * Class Xdebug
 * @package App\Phansible\Roles
 */
class Xdebug implements Role, RoleWithDependencies
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'XDebug';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'xdebug';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'xdebug';
    }

    /**
     * @return array
     */
    public function requiredRolesToBeInstalled(): array
    {
        return ['php'];
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
