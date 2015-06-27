<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Blackfire implements RoleInterface
{
    public function getName()
    {
        return 'Blackfire';
    }

    public function getSlug()
    {
        return 'blackfire';
    }

    public function getRole()
    {
        return 'blackfire';
    }

    public function requiresRoles()
    {
        return [];
    }

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'server_id' => '',
          'server_token' => '',
        ];
    }
}
