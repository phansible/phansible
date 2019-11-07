<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleWithDependencies;

class Xdebug implements Role, RoleWithDependencies
{
    public function getName()
    {
        return 'XDebug';
    }

    public function getSlug()
    {
        return 'xdebug';
    }

    public function getRole()
    {
        return 'xdebug';
    }

    public function requiredRolesToBeInstalled()
    {
        return ['php'];
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
        ];
    }
}
