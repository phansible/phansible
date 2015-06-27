<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Apache implements RoleInterface
{
    public function getName()
    {
        return 'Apache';
    }

    public function getSlug()
    {
        return 'apache';
    }

    public function getRole()
    {
        return 'apache';
    }

    public function requiresRoles()
    {
        return [];
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'docroot' => '/vagrant',
            'servername' => 'myApp.vb'
        ];
    }
}
