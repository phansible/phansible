<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Server implements RoleInterface
{
    public function getName()
    {
        return 'Server';
    }

    public function getSlug()
    {
        return 'server';
    }

    public function getRole()
    {
        return 'server';
    }

    public function getInitialValues()
    {
        return [
          'install' => 1,
          'timezone' => 'UTC',
          'locale' => 'en_US.UTF-8',
        ];
    }
}
