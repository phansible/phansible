<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Composer implements RoleInterface
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

    public function requiresRoles()
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
