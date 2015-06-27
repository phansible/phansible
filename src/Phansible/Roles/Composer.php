<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;
use Phansible\RoleWithDependencies;

class Composer implements RoleInterface, RoleWithDependencies
{
    public function getName()
    {
        return 'Composer';
    }

    public function getSlug()
    {
        return 'composer';
    }

    public function getRole()
    {
        return 'composer';
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
