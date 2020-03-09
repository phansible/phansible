<?php

namespace App\Phansible\Roles;

use App\Phansible\Role;
use App\Phansible\RoleWithDependencies;

/**
 * Class Composer
 * @package App\Phansible\Roles
 */
class Composer implements Role, RoleWithDependencies
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Composer';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'composer';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'composer';
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
