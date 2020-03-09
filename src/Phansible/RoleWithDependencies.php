<?php

namespace App\Phansible;

/**
 * Interface RoleWithDependencies
 * @package App\Phansible
 */
interface RoleWithDependencies
{
    /**
     * Specify a list of slug roles to be installed
     *
     * @return array The list of slugs of the roles to be installed
     */
    public function requiredRolesToBeInstalled(): array;
}
