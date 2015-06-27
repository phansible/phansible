<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Xdebug implements RoleInterface
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

    public function requiresRoles()
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
