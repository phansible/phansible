<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;

class Sqlite implements RoleInterface
{
    public function getName()
    {
        return 'SQLite';
    }

    public function getSlug()
    {
        return 'sqlite';
    }

    public function getRole()
    {
        return 'sqlite';
    }

    public function getInitialValues()
    {
        return [
          'install' => 0,
        ];
    }
}
