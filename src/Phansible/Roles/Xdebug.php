<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;
use Phansible\RoleWithDependencies;

class Xdebug implements RoleInterface, RoleWithDependencies
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
          'settings' => [],
        ];
    }
}
